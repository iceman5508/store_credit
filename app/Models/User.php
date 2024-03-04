<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'store_id',
        'role_id'
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
        'password' => 'hashed',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Store::class, 'id' );
    }


    public function verified(){
        return !empty($this->email_verified_at)? "Yes" : "No";
    }


    public function credit(){
        return $this->hasMany(Credit::class,'user_id', 'id');
    }

    public function credit_used(){
        $used = $this->credit()->where('value', '<', 0)->sum('value');
        return !empty($used) ? -1 * $used : 0;
    }

    public function lifetime_credit(){
        return $this->credit_used()+$this->available_credit();
    }
    public function available_credit(){
        return $this->credit()->sum('value');
    }
}
