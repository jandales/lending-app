<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Borrower extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'address',
        'phone',
        'avatar',
        'status',
        'user_id'
    ];


    public function loans()
    {
        return $this->hasMany(Loan::class)->orderBy('created_at', 'desc');
    }

   

    public function scopeSearch($query, $keyword)
    {
        return $query->where('firstname','LIKE', '%' . $keyword . '%' )
                ->orWhere('lastname', 'LIKE', '%' . $keyword . '%')
                ->orWhere('address', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email',  'LIKE', '%' . $keyword . '%')
                ->orWhere('phone',  'LIKE', '%' . $keyword . '%');
    }
}
