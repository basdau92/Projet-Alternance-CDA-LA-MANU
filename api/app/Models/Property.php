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
     * Relationship "One To Many" with the PropertyPictures model table. 
     */
    public function propertyPictures(){
        return $this->hasMany(PropertyPicture::class, 'id_property', 'id');
    }
}
