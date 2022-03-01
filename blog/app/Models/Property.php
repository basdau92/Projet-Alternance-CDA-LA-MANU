<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EnergyAudit;
use App\Models\PropertyType;
use App\Models\PropertyCategory;

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
     * Relationship "One To One through intermediate model" with the PropertyCategory model table.
     */
    public function PropertyCategories(){
        return $this->hasOneThrough(PropertyCategory::class, PropertyType::class, 'id', 'id');
    }
}
