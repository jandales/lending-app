<?php 

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\PaymentDueDate;


class DueDate { 

    private static array $payment_types = [
        'daily' => 1,
        'weekly' => 7,
        '15days' => 15,
        'monthly' => 30,
    ];

    public static function create($loan, $user_id)
    {        
        $due_date   = $loan->updated_at; 
        $days       = (int)Self::$payment_types[$loan->type];
        $daysToPay  = ((int)$loan->terms * 30) / (int)$days;

        for ( $i = 0; $i < $daysToPay; $i++ ) { 

            $due_date = Carbon::parse($due_date)->addDays($days);  

            PaymentDueDate::create([
                'loan_id' => $loan->id,
                'due_date' => $due_date,
                'collection_amount' => $loan->collection_amount,
                'amount_paid' => 0,    
                'user_id' => $user_id,
            ]);

        } 

        $loan->due_date_at = $due_date;
        $loan->save();

        return $due_date;
        
    }  

    

}