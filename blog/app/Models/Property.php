<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyType;
use App\Models\EnergyAudit;

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
     * Relationship with the EnergyAudit model table. 
     */
    public function hasOneEnergyAudits(){
        return $this->hasOne(EnergyAudit::class, 'id', 'id_energy_audit');
    }
    
    /**
     * Relationship with PropertyType model table.
     */
    public function hasOnePropertyTypes(){
        return $this->hasOne(PropertyType::class, 'id', 'id_property_type');
    }

    /**
     * Relationship with PropertyCategory model table.
     */
    public function hasOnePropertyCategories(){
        return $this->hasOne(PropertyCategories::class, 'id', 'id');
    }
}
