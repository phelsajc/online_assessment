<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrances extends Model
{
    protected $table = "entrances";

    protected $primaryKey = "entrances_id";

    public $timestamps = false;

    protected $fillable = [
        'entrance_id',
        'ent_code',
        'ent_description',
        'row_status',
        'inserted_by',
        'inserted_date',
    ];
}
