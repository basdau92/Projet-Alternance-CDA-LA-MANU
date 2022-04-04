<?php

namespace App\Models;

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
        'id_property', 'id_client', 'id_label', 'beginning', 'end', 'description', 'lastname', 'firstname', 'mail', 'phone', 'is_visit', 'address', 'city', 'zipcode'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}
