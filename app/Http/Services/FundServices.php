<?php 

namespace App\Http\Services;

use App\Models\Fund;
use App\Models\Loan;
use App\Models\User;
use App\Models\Payment;
use App\Models\FundActivity;
use App\Helpers\Status;
use App\Helpers\ActivityAction;
use App\Http\Resources\FundResource;

class FundServices 
{
    private $amount = 0;
    private $is_deduction = false;
    private $remark = '';
    
    private $fund;

    public  function __construct()
    {        
        $this->fund = Fund::find(1);
        
    } 

    public function getFund()
    {
        $this->syncLedgerHistory();
        $this->rebuildActivityBalances();

        return FundResource::make($this->fund->fresh()->load(['activities', 'activities.user']));
    }

    public function setAmount($amount)
    {   
        $this->amount = $amount;

        return $this;
    }

    public function isDeduction($value = true)
    {
        $this->is_deduction = (bool) $value;

        return $this;
    }

    public function addRermark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    public function getCurrentCapital()
    {        
        return $this->fund->current_capital;
    }

    public function hasFunds()
    {  
        if ($this->fund->current_capital <= 0) return false;
        return true;
    }

    public function updateCurrentCapital($userId = null, $remark = null)
    {
        $capital = $this->fund->current_capital;

        if ($this->is_deduction)
            $this->fund->current_capital -=  $this->amount;
        else
            $this->fund->current_capital +=  $this->amount;

        $this->fund->save();

        if ($userId) {
            $action = $this->is_deduction
                ? ActivityAction::$WITHDRAWAL
                : ActivityAction::$DEPOSIT;

            $this->addActivity(
                $userId,
                $action,
                $capital,
                $this->amount,
                $remark ?? ($this->is_deduction ? 'Capital deduction' : 'Capital deposit')
            );
        }

        return $this->fund;

    }

    public  function addFund($amount, $user, $remark)
    {
        $initial_capital = $this->fund->initial_capital;

        if ($initial_capital == 0) {
            $this->fund->initial_capital = $amount;
        }

        $capital = $this->fund->current_capital;
        $this->fund->current_capital += $amount;
        $this->fund->save();

        $this->addActivity($user, ActivityAction::$DEPOSIT, $capital, $amount, $remark);   
        return FundResource::make($this->fund->fresh()->load(['activities', 'activities.user']));
        
    }

    public  function deductFund($amount, $user, $remark)
    {
        $capital = $this->fund->current_capital;
        $this->fund->current_capital -= $amount;
        $this->fund->save();
        
        $this->addActivity($user, ActivityAction::$WITHDRAWAL, $capital, $amount, $remark);
        return FundResource::make($this->fund->fresh()->load(['activities', 'activities.user']));      
    }

    /**
     * Backfill loan/payment capital movements into fund_activities so Running Balance is complete.
     */
    public function syncLedgerHistory()
    {
        if (!$this->fund) {
            return;
        }

        $fallbackUserId = $this->fallbackUserId();
        $existingRemarks = $this->fund->activities()->pluck('remark')->filter()->all();

        // Loan disbursements (capital deducted on create)
        Loan::query()->with('user')->orderBy('id')->get()->each(function (Loan $loan) use (&$existingRemarks, $fallbackUserId) {
            $remark = 'Loan disbursement #'.$loan->loan_number;
            if (in_array($remark, $existingRemarks, true)) {
                return;
            }

            $this->fund->activities()->create([
                'fund_id' => $this->fund->id,
                'action' => ActivityAction::$WITHDRAWAL,
                'last_capital_amount' => 0,
                'amount' => $loan->principal_amount,
                'remark' => $remark,
                'user_id' => $loan->user_id ?: $fallbackUserId,
                'created_at' => $loan->created_at,
                'updated_at' => $loan->created_at,
            ]);
            $existingRemarks[] = $remark;
        });

        // Rejected loans restore capital
        Loan::query()->where('status', Status::$REJECTED)->with('user')->orderBy('id')->get()
            ->each(function (Loan $loan) use (&$existingRemarks, $fallbackUserId) {
                $remark = 'Loan rejected #'.$loan->loan_number.' - capital restored';
                if (in_array($remark, $existingRemarks, true)) {
                    return;
                }

                $this->fund->activities()->create([
                    'fund_id' => $this->fund->id,
                    'action' => ActivityAction::$DEPOSIT,
                    'last_capital_amount' => 0,
                    'amount' => $loan->principal_amount,
                    'remark' => $remark,
                    'user_id' => $loan->user_id ?: $fallbackUserId,
                    'created_at' => $loan->updated_at,
                    'updated_at' => $loan->updated_at,
                ]);
                $existingRemarks[] = $remark;
            });

        // Paid payments add capital back
        Payment::query()->where('status', Status::$PAID)->with(['user', 'loan'])->orderBy('id')->get()
            ->each(function (Payment $payment) use (&$existingRemarks, $fallbackUserId) {
                $prefix = 'Payment received #'.$payment->id;
                if ($this->remarkExists($existingRemarks, $prefix)) {
                    return;
                }
                // Also skip legacy forward-logged rows that used a generic remark around the same amount/time
                if ($this->hasLegacyPaymentRemark($payment)) {
                    return;
                }

                $loanLabel = $payment->loan?->loan_number ? ' (Loan #'.$payment->loan->loan_number.')' : '';
                $remark = $prefix.$loanLabel;

                $this->fund->activities()->create([
                    'fund_id' => $this->fund->id,
                    'action' => ActivityAction::$DEPOSIT,
                    'last_capital_amount' => 0,
                    'amount' => $payment->amount,
                    'remark' => $remark,
                    'user_id' => $payment->user_id ?: $fallbackUserId,
                    'created_at' => $payment->created_at,
                    'updated_at' => $payment->created_at,
                ]);
                $existingRemarks[] = $remark;
            });

        // Voided payments reverse the capital add
        Payment::query()->where('status', Status::$VOID)->with(['user', 'loan'])->orderBy('id')->get()
            ->each(function (Payment $payment) use (&$existingRemarks, $fallbackUserId) {
                $prefix = 'Payment voided #'.$payment->id;
                if ($this->remarkExists($existingRemarks, $prefix)) {
                    return;
                }

                $this->fund->activities()->create([
                    'fund_id' => $this->fund->id,
                    'action' => ActivityAction::$WITHDRAWAL,
                    'last_capital_amount' => 0,
                    'amount' => $payment->amount,
                    'remark' => $prefix,
                    'user_id' => $payment->user_id ?: $fallbackUserId,
                    'created_at' => $payment->updated_at,
                    'updated_at' => $payment->updated_at,
                ]);
                $existingRemarks[] = $prefix;
            });
    }

    private function fallbackUserId(): int
    {
        return (int) (User::query()->orderBy('id')->value('id') ?: 1);
    }

    /**
     * Recompute last_capital_amount chronologically and align current_capital with the ledger.
     */
    public function rebuildActivityBalances()
    {
        if (!$this->fund) {
            return;
        }

        $activities = FundActivity::query()
            ->where('fund_id', $this->fund->id)
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        $balance = 0;

        foreach ($activities as $activity) {
            $activity->last_capital_amount = $balance;
            $delta = $activity->action === ActivityAction::$DEPOSIT
                ? (float) $activity->amount
                : -(float) $activity->amount;
            $balance += $delta;
            $activity->save();
        }

        $this->fund->current_capital = $balance;
        $this->fund->save();
    }

    private function remarkExists(array $existingRemarks, string $prefix): bool
    {
        foreach ($existingRemarks as $remark) {
            if ($remark === $prefix || str_starts_with((string) $remark, $prefix)) {
                return true;
            }
        }

        return false;
    }

    private function hasLegacyPaymentRemark(Payment $payment): bool
    {
        return $this->fund->activities()
            ->where('action', ActivityAction::$DEPOSIT)
            ->where('amount', $payment->amount)
            ->where('remark', 'Payment received')
            ->whereDate('created_at', optional($payment->created_at)->toDateString())
            ->exists();
    }

    private function addActivity($user, $action, $capital_amount, $amount, $remark)
    {

        $activity =  $this->fund->activities()->create([
            'fund_id' => $this->fund->id,
            'action' => $action,
            'last_capital_amount' => $capital_amount,
            'amount' => $amount,
            'remark' => $remark,
            'user_id' => $user,
        ]); 

        return $activity;

    }
    
}
