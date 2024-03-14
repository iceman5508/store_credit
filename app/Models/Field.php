<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * Get all fields and enabled fields in relation to list
     * @param int $id
     * @return array
     */
    public static function storeEnabled(int $id){
       return DB::select("
                            SELECT f.id AS field_id, f.name, ef.store_id, ef.status, ef.id AS 'enabled_id'
                            FROM fields f
                            LEFT JOIN enabled_fields ef ON ef.field_id = f.id
                            WHERE store_id = ? OR (ef.store_id IS NULL AND ef.status IS NULL)", [$id]);
    }

}
