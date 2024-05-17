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
        'owner_id',
        'package_id',
        'expired_at',
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

    /**
     * Return all employees
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees(){
        return $this->users()->where('role_id','=', 2);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credit(){
        return $this->hasMany(Credit::class,'store_id', 'id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enabled_fields(){
        return $this->hasMany(EnabledField::class,'store_id','id');
    }

    /**
     * Return all the user fields
     * @param int $user_id
     * @param int $store_id
     * @return array
     */
    public function userFields(int $user_id): array
    {
        $fields = [];
        foreach ($this->active_fields()->get() as $efields){
            $value = $efields->field->storeUserValue($this->id, $user_id);
            if(!empty($value)){
                $value = $value[0];

                $field = [
                            'field_id' => $efields->field->id,
                            'name' => $efields->field->name,
                            'value' =>$value->value,
                            'user_id' => $user_id,
                            'um_id' => $value->id
                ];
            }else{
                $field = [
                    'field_id' => $efields->field->id,
                    'name' => $efields->field->name,
                    'value' =>'',
                    'user_id' => $user_id,
                    'um_id' => ''
                ];
            }

            $fields[$efields->field->name] = $field;
        }
        return $fields;

    }

    /**
     * Get the current package
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }


    public function active_fields(){
        return $this->enabled_fields()->where('status',1);
    }





}
