<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'owner_id'
    ];

    /**
     *Get all users tied to store
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(){
        return $this->hasMany(User::class);
    }

    /**
     * Get all store customers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers(){
        return $this->users()->where('role_id','=', 3);
    }


    public function credit(){
        return $this->hasMany(Credit::class,'store_id', 'id');
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
