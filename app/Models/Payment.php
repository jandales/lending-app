<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'remark',
        'customer_id',
        'loan_id',
        'user_id',
        'status'
                
    ];

    protected $dates = [
        'created_at',
    ];

    public function getCreatedFormatAttribute()
    {  
        return $this->created_at->format('Y-m-d H:i:s');
    }
    
    protected $appends = ['created_format'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    
}
