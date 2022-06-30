<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Models\Feature;

class FeaturesList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_feature',
        'id_property'
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
    public function property()
    {
        return $this->belongsTo(Property::class, 'id_property', 'id');
    }

    /**
     * Relationship "One to One" with the Hygiene model table. 
     */
    public function features()
    {
        return $this->hasMany(Feature::class, 'id_feature', 'id');
    }

    // /**
    //  * Relationship "One To Many" through intermediate model with the Annexe model table. 
    //  */
    // public function parkingNumbers(){
    //     return $this->hasManyThrough(ParkingNumber::class, Annexe::class, 'id_annexe', 'id');
    // }
}
