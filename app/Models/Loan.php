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
        'amount',
        'total_amount',
        'balance_amount',
        'user_id',
        'status',
    ];

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
        $loan = $query->where('customer_id',$id)
                      ->where('status', 'approved')                     
                      ->first();
        if($loan == null) return false;
        return true;
    }
}
