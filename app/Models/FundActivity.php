<?php

namespace App\Models;

use App\Models\Fund;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FundActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'fund_id',
        'action',
        'last_capital_amount',
        'amount',
        'remark',
        'user_id',
    ];

    protected $dateFormat = 'Y-m-d';
    
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function fund() 
    {
        return $this->belongsTo(Fund::class, 'fund_id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
