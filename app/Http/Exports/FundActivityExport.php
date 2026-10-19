<?php

namespace App\Http\Exports;

use App\Helpers\ActivityAction;
use App\Helpers\FundActivityLabel;
use App\Models\Fund;
use App\Models\FundActivity;

class FundActivityExport extends Export
{
    public function handleExport()
    {
        $fund = Fund::query()->find(1);

        if (!$fund) {
            return $this->csv($this->columns(), []);
        }

        $activities = FundActivity::query()
            ->where('fund_id', $fund->id)
            ->with('user')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $data = [];

        foreach ($activities as $activity) {
            $data[] = $this->format($activity);
        }

        return $this->csv($this->columns(), $data);
    }

    public function format(FundActivity $activity): array
    {
        $signedAmount = $activity->action === ActivityAction::$DEPOSIT
            ? (float) $activity->amount
            : -(float) $activity->amount;

        $runningBalance = (float) $activity->last_capital_amount + $signedAmount;

        return [
            optional($activity->created_at)->toFormattedDateString(),
            FundActivityLabel::from($activity->action, $activity->remark),
            number_format($signedAmount, 2, '.', ''),
            number_format((float) $activity->last_capital_amount, 2, '.', ''),
            number_format($runningBalance, 2, '.', ''),
            $activity->remark,
            optional($activity->user)->name,
            optional($activity->user)->email,
        ];
    }

    public function columns(): array
    {
        return [
            'Date',
            'Action',
            'Amount',
            'Last Capital Amount',
            'Running Balance',
            'Remark',
            'User',
            'Email',
        ];
    }
}
