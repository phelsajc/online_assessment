<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Selfassessment extends Model
{
    protected $table = "self_assessment";

    protected $primaryKey = "self_assessment_id";

    public $timestamps = false;

    protected $fillable = [
        'self_assessment_id',
        'user_id',
        'assessment_datetime',
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
        'row_status',
        'created_dt',
        'created_by',
    ];
}
