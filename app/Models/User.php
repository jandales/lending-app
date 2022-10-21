<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roleInWord()
    {
        $role = null;

        if ($this->role == 0) return 'Super Admin';

        if ($this->role == 1) return 'Admin';

        if ($this->role == 2) return 'Employee';

    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('name','LIKE', '%' . $keyword . '%' )               
                ->orWhere('address', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email',  'LIKE', '%' . $keyword . '%')
                ->orWhere('phone',  'LIKE', '%' . $keyword . '%');
    }
}
