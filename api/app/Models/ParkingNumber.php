<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Annexe;

class ParkingNumber extends Model
{
    protected $table = 'parking_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
<<<<<<< HEAD
        'number',
        'id_annexe',
        'id_property'
=======
        'number'
>>>>>>> IB
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'laravel_through_key'
    ];
}
