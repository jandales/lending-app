<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    use HasFactory;

    protected $fillable = ['capital', 'less_capital', 'current_capital', 'status'];

    public function hasFunds($amount)
    {        
        if ($this->current_capital < $amount) return false;
        return true;    
    }

    public function scopeGetCapital($query)
    {
        return $query->where('status', 1);
    }

}
