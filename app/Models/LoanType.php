<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
        'interest',
        'amount_to_pay',
        'due_type',
        'user_id'
    ];


}
