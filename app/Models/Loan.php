<?php

namespace App\Models;


use App\Helpers\Status;
use App\Models\PaymentDueDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_number',
        'borrower_id', 
        'terms',
        'type',
        'collection_amount',       
        'total_interest', 
        'principal_amount',
        'interest',
        'effective_at',
        'total_amount',
        'balance_amount',
        'user_id',
        'status',
    ]; 

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }

    public function dueDates()
    {
        return $this->hasMany(PaymentDueDate::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::$ACTIVE)->latest('created_at');
    }

    public function scopeExistingLoan($query, $id)
    {      
        $loan = $query->where('borrower_id', $id)->where(function ($q) {
                        $q->where('status', Status::$APPROVED)
                        ->orWhere('status', Status::$PENDING)
                        ->orWhere('status', Status::$ACTIVE);
                })->first();

        return $loan === null ? false : true;

    }

    public function scopeTotalInterest($query)
    {
        return $query->where('status', Status::$ACTIVE)
                     ->orWhere('status', Status::$PAID)
                     ->sum('total_interest');
                     
    }

    public function scopeCollectableInterest($query)
    {
        return $query->where('status', Status::$ACTIVE)               
                     ->sum('total_interest');
                     
    }

    public function scopeTotalCollectedInterest()
    {
        $total_interest  = $this->TotalInterest();
        $collectable = $this->CollectableInterest(); 
        return $total_interest - $collectable;        
    }
    
    public function updateBalance($balance)
    {      

        if ($balance <= 0) {
            $this->status = Status::$PAID;
            $balance = 0;
        } 
        $this->balance_amount = $balance;  
        $this->save();

        return $this;        
        
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->save();
        return $this;
    }



    public function scopeSearch($query, $keyword)
    {    
        
       return $query->with('borrower')                    
                    ->Where('loan_number', 'LIKE', '%' . $keyword . '%')                   
                    ->orWhereHas('borrower', function ($q) use ($keyword) {
                        $q->where('firstname', 'LIKE', '%' . $keyword . '%')
                          ->orWhere('lastname', 'LIKE', '%' . $keyword . '%');  
                    });
                  

    }



}
