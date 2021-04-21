<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    protected $table = "temp";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'entrance_id',
        'inserted_date',
        'user_id',
        'user_temp',
    ];
}
