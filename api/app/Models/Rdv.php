<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Label;
use Illuminate\Database\Eloquent\Model;

class Rdv extends Model
{

    protected $table = 'rdv';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_employee',
        'id_property',
        'id_client',
        'id_label',
        'id_agency',
        'beginning',
        'end',
        'description',
        'lastname',
        'firstname',
        'mail',
        'phone',
        'is_visit',
        'address',
        'city',
        'zipcode',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'id_employee',
        'id_property',
        'id_client',
        'id_label',
        'id_agency',
        'is_visit',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationship "Inversed One To Many" with the Employee model table.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }

    /**
     * Relationship "One To One" with the Label model table.
     */
    public function label()
    {
        return $this->hasOne(Label::class, 'id', 'id_label');
    }
}
