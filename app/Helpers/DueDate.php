<?php 

namespace App\Helpers;

use Carbon\Carbon;
use App\Helpers\PaymentType;
use App\Helpers\Status;
use App\Models\PaymentDueDate;


class DueDate { 

    private static $date = null;

    public static function create($loan, $user_id)
    {        
        $due_date   = $loan->updated_at; 
        $days       = (int)PaymentType::getValue($loan->type);
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

    public static function find($id)
    {
       $dueDate = PaymentDueDate::find($id);
       self::$date = $dueDate;
       return new self;
    }


    public  function getDate()
    {
        return self::$date;
    }

    public static function findByLoan($id)
    {
       $dueDate = PaymentDueDate::with('loan')->where('loan_id', $id)->orderBy('id', 'desc')->first(); 
       self::$date = $dueDate;
       return new self;
    }


    public static function update($amount, $balance)
    {       
        $balance = $balance <= 0 ? 0 : $balance;  
        self::$date->paid_at = now();
        self::$date->amount_paid = $amount;
        self::$date->balance = $balance;
        self::$date->status = STATUS::$PAID;        
        self::$date->save();        
        return self::$date;
    }

    public static function void()
    {
        self::$date->amount_paid = 0;
        self::$date->balance = 0;
        self::$date->paid_at = null;
        self::$date->status = null;
        self::$date->save();
    }

    public  static function failedPayment()
    {       
        self::$date->amount_paid = 0;    
        self::$date->status = STATUS::$FAILED;        
        self::$date->save();
        return self::$date;
    }

    public function addDays($count = 1)
    {
        $due_date = self::$date->due_date;        
        $due_date = Carbon::parse($due_date)->addDays($count); 

        return PaymentDueDate::create([
            'loan_id' => self::$date->loan_id,
            'due_date' => $due_date,
            'collection_amount' => self::$date->collection_amount,
            'amount_paid' => 0,    
            'user_id' => self::$date->user_id,
        ]);    
    }

    public static function isLastDate($date)
    {
 
        $due_date = Carbon::parse(self::$date->due_date)->format('m/d/Y'); 
        $date = Carbon::parse($date)->format('m/d/Y');         
        if ($due_date == $date)  return true;
        return false;              
    }
    
  
    

}