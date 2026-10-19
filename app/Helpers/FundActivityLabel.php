<?php

namespace App\Helpers;

class FundActivityLabel
{
    public static function from(?string $action, ?string $remark): string
    {
        $remark = trim((string) $remark);

        if ($remark !== '' && stripos($remark, 'Payment received') === 0) {
            return 'Payment Received';
        }

        if ($remark !== '' && stripos($remark, 'Loan disbursement') === 0) {
            return 'Loan Disbursement';
        }

        if ($remark !== '' && stripos($remark, 'Payment voided') === 0) {
            return 'Payment Voided';
        }

        if ($remark !== '' && stripos($remark, 'Loan rejected') === 0) {
            return 'Loan Rejected';
        }

        if ($action === ActivityAction::$DEPOSIT) {
            return 'Deposit';
        }

        if ($action === ActivityAction::$WITHDRAWAL) {
            return 'Withdrawal';
        }

        return $action ? ucfirst($action) : '';
    }
}
