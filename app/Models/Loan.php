<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'loan_type_id',
        'principal_amount',
        'interest',
        'effective_at',
        'total_amount',
        'balance_amount',
        'user_id',
        'status',
    ];

    public static $STATUS_APPROVED = 'approved';
    public static $STATUS_RELEASED = 'released';
    public static $STATUS_PENDING = 'pending';
    public static $STATUS_PAID = 'paid';
    public static $STATUS_REJECT = 'rejected';
    public static $STATUS_VOID = 'void';

    protected $dates = [
        'created_at',
    ];

    public function getCreatedFormatAttribute()
    {  
        return $this->created_at->format('d-m-Y');
    }
    
    protected $appends = ['created_format'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
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

    public function scopeExistingLoan($query, $id)
    {      
        
        $loan = $query->where('customer_id', $id)->where(function ($q) {
                        $q->where('status', Self::$STATUS_APPROVED)
                        ->orWhere('status', Self::$STATUS_PENDING)
                        ->orWhere('status', Self::$STATUS_RELEASED);
                    })->first();

        return  $loan === null ? false : true;
    }

    public function scopeCapital($query)
    {   
        $capital = 0;
        $loans =  $query->get();
        if($loans == null) return 0;

        forEach ($loans as $loan) {
            $capital += $loan->principal_amount;
        }

        return $capital;
        
        
    }

    public function scopeRevenue($query)
    {   
        $capital = 0; $interest = 0;        
        $loans =  $query->with('loanType')->get();
        if($loans == null) return 0;

        forEach ($loans as $loan) {
            $interest += $loan->loanType->interest;
            $capital += $loan->principal_amount;
        }
        $total = $capital + ($capital * ($interest / 100));
        return $total;
        
        
    }

    public function scopeSearch($query, $keyword)
    {      
        
       return $query->with('customer')
                    ->where('id', 'LIKE', '%' . $keyword . '%')
                    ->where('status', '!=', 'void')                  
                    ->orWhereHas('customer', function ($q) use ($keyword) {
                        $q->where('firstname', 'LIKE', '%' . $keyword . '%')
                          ->orWhere('lastname', 'LIKE', '%' . $keyword . '%');                      
                    })                                      
                    ->get();
    }
}
