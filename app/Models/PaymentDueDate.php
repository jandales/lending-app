<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDueDate extends Model
{
    use HasFactory;

    protected $fillable = [       
        'loan_id',
        'due_date',
        'collection_amount',
        'amount_paid',
        'balance',
        'status',
        'paid_at',
        'user_id',     
    ];

    public function loan()
    {

        return $this->belongsTo(Loan::class);

    }
}
