<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegHealthCheck extends Model
{
    protected $table = "reg_health_check";

    protected $primaryKey = "reg_health_check_id";

    public $timestamps = false;

    protected $fillable = [
        'reg_health_check_id',
        'lastname',
        'firstname',
        'current_address',
        'city_id',
        'cellphone_no',
        'gender',
        'birthdate',
        'visiting_type',
        'visit_reason',
        'location_of_visit',
        'body_temp',
        'fever',
        'loss_of_smell',
        'cough',
        'muscle_aches',
        'sore_throat',
        'shortness_of_breath',
        'chills',
        'headache',
        'vomiting_diarrhea_loss_of_appetite',
        'close_contact_with_covid_patient',
        'asked_to_self_isolate',
        'unique_code',
        'inserted_location',
        'inserted_date',
        'expiry_date',
        'has_swab',
        'swab_date',
    ];
}
