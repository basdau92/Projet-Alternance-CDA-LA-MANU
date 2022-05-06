<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
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
     * Relationship "Inversed One to Many" with the Property model table. 
     */
    public function property(){
        return $this->belongsTo(Property::class, 'id_property', 'id');
    }

    /**
     * Relationship "One to One" with the Hygiene model table. 
     */
    public function hygienes(){
        return $this->hasOne(Hygiene::class, 'id_hygiene', 'id');
    }

    /**
     * Relationship "One to One" with the Outdoor model table. 
     */
    public function outdoors(){
        return $this->hasOne(Outdoor::class, 'id_outdoor', 'id');
    }

    /**
     * Relationship "One to One" with the Annexe model table. 
     */
    public function annexes(){
        return $this->hasOne(Annexe::class, 'id_annexe', 'id');
    }

    // /**
    //  * Relationship "One To Many" through intermediate model with the Annexe model table. 
    //  */
    // public function parkingNumbers(){
    //     return $this->hasManyThrough(ParkingNumber::class, Annexe::class, 'id_annexe', 'id');
    // }
}
