<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'address',
        'phone',
        'avatar',
        'user_id'
    ];

    public function scopeSearch($query, $keyword)
    {
        return $query->where('firstname','LIKE', '%' . $keyword . '%' )
                ->orWhere('lastname', 'LIKE', '%' . $keyword . '%')
                ->orWhere('address', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email',  'LIKE', '%' . $keyword . '%')
                ->orWhere('phone',  'LIKE', '%' . $keyword . '%');
    }
}
