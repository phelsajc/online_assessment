<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";

    protected $primaryKey = "user_id";

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'emp_no',
        'lastname',
        'firstname',
        'middlename',
        'address',
        'city_id',
        'birthdate',
        'civil_status',
        'gender',
        'blood_type',
        'position_id',
        'picture',
        'is_rmci_employee',
        'row_status',
        'inserted_by',
        'inserted_date',
        'updated_by',
        'updated_date',
        'username',
        'password',
        'department_id',
        'contact_no',
        'other_contact_no',
        'is_admin',
        'is_supervisor',
        'id',
        'is_active',
    ];
}
