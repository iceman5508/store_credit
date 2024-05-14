<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        return $this->hasOne(Store::class, 'id' , 'store_id');
    }


    /**
     * @return string
     */
    public function verified(){
        return !empty($this->email_verified_at)? "Yes" : "No";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credit(){
        return $this->hasMany(Credit::class,'user_id', 'id');
    }

    /**
     * @return float|int
     */
    public function credit_used(){
        $used = $this->credit()->where('value', '<', 0)->sum('value');
        return !empty($used) ? -1 * $used : 0;
    }

    /**
     * @return float|int|mixed
     */
    public function lifetime_credit(){
        return $this->credit_used()+$this->available_credit();
    }

    /**
     * @return int|mixed
     */
    public function available_credit(){
        return $this->credit()->sum('value');
    }

    /**
     * @param $user_id
     * @return void
     */
    public static function store_fields($user_id){
        $store = Auth::user()->store->id;
        return DB::select("
               SELECT um.id as um_id, um.user_id, um.value, f.id AS field_id, f.name
                            FROM fields f
                            LEFT JOIN enabled_fields ef ON ef.field_id = f.id
                            Left JOIN users_meta um ON um.field_id = f.id
                            WHERE (ef.store_id = ? OR (ef.store_id IS NULL AND ef.status IS NULL) )
                            AND ( um.user_id = ? OR (um.store_id IS NULL AND um.user_id IS NULL))
                            AND (ef.status = 1 OR ef.status IS NULL)
        ", [$store, $user_id]);
    }
}
