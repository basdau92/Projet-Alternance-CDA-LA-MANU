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
        'number',
        'id_annexe'
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

    /**
     * Relationship "inversed One To Many" with the Annexe model table. 
     */
    public function parkingNumbers(){
        return $this->belongsTo(Annexe::class);
    }
}
