<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hygiene;
use App\Models\Outdoor;
use App\Models\Annexe;
use App\Models\ParkingNumber;

class FeaturesList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_hygiene',
        'id_outdoor',
        'id_property',
        'id_annexe'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $table = 'features_list';

    /**
     * Relationship "One To Many" with the Hygiene model table. 
     */
    public function hygienes(){
        return $this->hasMany(Hygiene::class);
    }

    /**
     * Relationship "One To Many" with the Outdoor model table. 
     */
    public function outdoors(){
        return $this->hasMany(Outdoor::class);
    }

    /**
     * Relationship "One To Many" with the Annexe model table. 
     */
    public function annexes(){
        return $this->hasMany(Annexe::class);
    }

    /**
     * Relationship "One To One" through intermediate model with the Annexe model table. 
     */
    public function parkingNumbers(){
        return $this->hasOneThrough(ParkingNumber::class, Annexe::class, 'id', 'id');
    }
}
