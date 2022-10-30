<?php 

namespace App\Http\Services;

use App\Models\Fund;
use App\Models\Capital;

class FundServices 
{
    private $amount = 0;
    private $is_deduction = false;
    private $remark = '';
    
    private  $fund;

    public  function __construct()
    {
        $this->fund = Fund::find(1);
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

    public function storeInitialFund($amount)
    {
        return Fund::create([
            'intial_capital' => $amount,
            'current_capital' => $amount,
        ]);
    }

    public  function addFund($amount, $remark = null)
    {
          $this->fund->current_capital += $amount;
          $this->fund->save();           
          $this->fund->activies->create('add', $remark);
        
    }

    public  function deductFund($amount, $remark = null)
    {
          $this->fund->current_capital -= $amount;
          $this->fund->save();           
          $this->fund->activies->create('deduct', $remark);        
    }
}