<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrScan extends Model
{
    protected $table = "scanner_logs";

    protected $primaryKey = "scanner_log_id";

    public $timestamps = false;

    protected $fillable = [
        'scanner_log_id',
        'scanner_entrance_id',
        'unique_code',
        'inserted_date',
        'is_expired',
    ];
}
