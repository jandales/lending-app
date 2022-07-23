<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordReset extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
