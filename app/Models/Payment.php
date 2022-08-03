<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'due_date',
        'amount',
        'remark',
        'borrower_id',
        'loan_id',
        'user_id',
        'status'
                
    ];

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
