<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class defualt_send_to extends Model
{
    protected $table = "defualt_send_to";

    protected $primaryKey = "defualt_send_to_id";

    public $timestamps = false;

    protected $fillable = [
        'defualt_send_to_id',
        'emp_no',
        'fullname',
        'mobile_no',
        'row_status',
        'inserted_by',
        'inserted_date',
    ];
}
