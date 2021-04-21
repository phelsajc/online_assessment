<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrScanLogin extends Model
{
    protected $table = "scanner_entrance";

    protected $primaryKey = "scanner_entrance_id";

    public $timestamps = false;

    protected $fillable = [
        'scanner_entrance_id',
        'entrance_name',
        'username',
        'password',
        'row_status',
    ];
}
