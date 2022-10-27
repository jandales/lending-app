<?php 

namespace App\Http\Services;

use App\Models\Capital;

class FundServices 
{
    private $amount = 0;
    private $is_deduction = false;
    private $remark = '';
    

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
        $capital = Capital::GetCapital()->first();
        
        return $capital->current_capital;
    }

    public function hasFunds()
    {      
        $capital = Capital::GetCapital()->first();  
        
        return $capital->hasFunds(0);
    }

    public function updateCurrentCapital()
    {
        $capital = Capital::GetCapital()->first();

        if ($this->is_deduction) 
            $capital->current_capital -=  $this->amount;
        else 
            $capital->current_capital +=  $this->amount;              
      
        $capital->save();  

        return $capital;

    }
}