<?php 

namespace App\Http\Services;

use App\Models\Fund;
use App\Models\Capital;
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
        return FundResource::make($this->fund->load(['activities', 'activities.user']));
    }

    public function setAmount($amount)
    {   
        $this->amount = $amount;

        return $this;
    }

    public function isDeduction()
    {
        $this->is_deduction = true;

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

    public function updateCurrentCapital()
    {        
        if ($this->is_deduction) 
            $this->fund->current_capital -=  $this->amount;
        else 
            $this->fund->current_capital +=  $this->amount;      
    
        $this->fund->save();

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
        return FundResource::make($this->fund->load(['activities', 'activities.user']));
        
    }

    public  function deductFund($amount, $user, $remark)
    {
        $capital = $this->fund->current_capital;
        $this->fund->current_capital -= $amount;
        $this->fund->save();
        
        $this->addActivity($user, ActivityAction::$WITHDRAWAL, $capital, $amount, $remark);
        return FundResource::make($this->fund->load(['activities', 'activities.user']));      
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