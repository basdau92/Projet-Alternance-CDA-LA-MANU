<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyPicture;
use App\Models\PropertyList;

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
        'id_property_category',
        'id_kitchen',
        'id_heater',
        'name',
        'price',
        'address',
        'addition_address',
        'zipcode',
        'city',
        'surface',
        'description',
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
    public function energyAudits()
    {
        return $this->hasOne(EnergyAudit::class, 'id', 'id_energy_audit');
    }

    /**
     * Relationship "One To One" with the PropertyType model table.
     */
    public function propertyTypes()
    {
        return $this->hasOne(PropertyType::class, 'id', 'id_property_type');
    }

    /**
     * Relationship "One To One" with the PropertyTransactionType model table.
     */
    public function propertyTransactionType()
    {
        return $this->hasOne(PropertyTransactionType::class, 'id', 'id_property_transaction_type');
    }

    /**
     * Relationship "One To One" with the PropertyCategory model table.
     */
    public function propertyCategories()
    {
        return $this->hasOne(PropertyCategory::class, 'id', 'id_property_category');
    }

    /**
     * Relationship "One To Many" with the PropertyPictures model table. 
     */
    public function propertyPictures()
    {
        return $this->hasMany(PropertyPicture::class, 'id_property', 'id');
    }

    /**
     * Relationship "One To One" with the Kitchen model table. 
     */
    public function kitchen()
    {
        return $this->hasOne(Kitchen::class, 'id', 'id_kitchen');
    }

    /**
     * Relationship "One To One" with the Heater model table. 
     */
    public function heater()
    {
        return $this->hasOne(Heater::class, 'id', 'id_heater');
    }

    /**
     * Relationship "One To Many" through intermediate model with the RoomType model table. 
     */
    public function rooms()
    {
        return $this->hasMany(Room::class, 'id_property', 'id');
    }

    /**
     * Relationship "One To Many" through intermediate model with the RoomType model table. 
     */
    public function roomTypes()
    {
        return $this->hasManyThrough(RoomType::class, Room::class, 'id_room_type', 'id');
    }

    /**
     * Relationship "One To Many" with the FeaturesList model table. 
     */
    public function featuresLists()
    {
        return $this->hasMany(FeaturesList::class, 'id_property', 'id');
    }

    /**
     * Relationship "One To Many" through intermediate model with the Hygiene model table. 
     */
    public function features()
    {
        return $this->hasManyThrough(Feature::class, FeaturesList::class, 'id_feature', 'id');
    }

    public function propertyList()
    {
        return $this->hasMany(PropertyList::class, 'id_property', 'id');
    }
}
