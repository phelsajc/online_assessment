<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryLog extends Model
{
    protected $table = "visited_entrance";

    protected $primaryKey = "visited_entrance_id";

    public $timestamps = false;

    protected $fillable = [
        'visited_entrance_id',
        'user_id',
        'entrance_id',
        'entrance_datetime',    
        'row_status',
        'created_dt',
        'created_by',
    ];
}
