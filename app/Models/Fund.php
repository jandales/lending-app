<?php

namespace App\Models;

use App\Models\FundActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = [
        'initial_capital',
        'current_capital',
    ];

    public function activities() 
    {
        return $this->hasMany(FundActivity::class, 'fund_id', 'id')->orderBy('id', 'desc');
    }

}
