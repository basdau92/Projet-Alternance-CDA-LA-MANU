<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyType;

class Property extends Model
{
    protected $table = 'property';
    
    /**
     * Get the types of all properties  
     */
    public function hasManyProperties(){
        
        return $this->hasMany(PropertyType::class);
    }

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
     * Retrieve all properties by name.
     * 
     * 
     */
    // public function getAllProperties() {
    //     foreach (Property::all() as $property) {
    //         echo $property->name;
    //     }
    // }

}
