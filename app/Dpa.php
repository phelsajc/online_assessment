<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpa extends Model
{
    protected $table = "dpa";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'inserted_date',
        'user_id',
        'status',
    ];
}
