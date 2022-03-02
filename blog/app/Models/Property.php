<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EnergyAudit;
use App\Models\PropertyType;
use App\Models\PropertyCategory;
use App\Models\PropertyPicture;
use App\Models\Kitchen;
use App\Models\Heater;
use App\Models\Room;
use App\Models\RoomTypes;
use App\Models\FeaturesList;
use App\Models\Hygiene;
use App\Models\Outdoor;
use App\Models\Annexe;
use App\Models\ParkingNumber;

class Property extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_property_type',
        'id_kitchen',
        'id_heater',
        'name', 
        'price', 
        'number', 
        'address', 
        'addition_address', 
        'zipcode', 
        'description', 
        'surface', 
        'floor', 
        'is_furnished', 
        'is_available', 
        'is_prospect'
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

    /**
     * Define table that should be used by the model.  
     */
    protected $table = 'property';

    /**
     * Relationship "One To One" with the EnergyAudit model table. 
     */
    public function EnergyAudits(){
        return $this->hasOne(EnergyAudit::class, 'id', 'id');
    }
    
    /**
     * Relationship "One To One" with the PropertyType model table.
     */
    public function PropertyTypes(){
        return $this->hasOne(PropertyType::class, 'id', 'id');
    }

    /**
     * Relationship "One To One" through intermediate model with the PropertyCategory model table.
     */
    public function PropertyCategories(){
        return $this->hasOneThrough(PropertyCategory::class, PropertyType::class, 'id', 'id');
    }

    /**
     * Relationship "One To Many" with the PropertyPictures model table. 
     */
    public function PropertyPictures(){
        return $this->hasMany(PropertyPicture::class, 'id', 'id');
    }

    /**
     * Relationship "One To One" with the Kitchen model table. 
     */
    public function Kitchen(){
        return $this->hasOne(Kitchen::class, 'id', 'id');
    }

    /**
     * Relationship "One To One" with the Heater model table. 
     */
    public function Heater(){
        return $this->hasOne(Heater::class, 'id', 'id');
    }

    /**
     * Relationship "One To Many" through intermediate model with the RoomType model table. 
     */
    public function Rooms(){
        return $this->hasMany(Room::class, 'id', 'id');
    }

    /**
     * Relationship "One To Many" through intermediate model with the RoomType model table. 
     */
    public function RoomTypes(){
        return $this->hasManyThrough(RoomType::class, Room::class, 'id', 'id');
    }

    /**
     * Relationship "One To Many" with the FeaturesList model table. 
     */
    public function FeaturesLists(){
        return $this->hasMany(FeaturesList::class, 'id', 'id');
    }

    /**
     * Relationship "One To Many" through intermediate model with the Hygiene model table. 
     */
    public function Hygienes(){
        return $this->hasManyThrough(Hygiene::class, FeaturesList::class, 'id', 'id');
    }

    /**
     * Relationship "One To Many" through intermediate model with the Outdoor model table. 
     */
    public function Outdoors(){
        return $this->hasManyThrough(Outdoor::class, FeaturesList::class, 'id', 'id');
    }

    /**
     * Relationship "One To Many" through intermediate model with the Annexe model table. 
     */
    public function Annexes(){
        return $this->hasManyThrough(Annexe::class, FeaturesList::class, 'id', 'id');
    }

    /**
     * Relationship "One To One" through intermediate model with the Annexe model table. 
     */
    public function ParkingNumbers(){
        return $this->hasOneThrough(ParkingNumber::class, Annexe::class, 'id', 'id');
    }
}
