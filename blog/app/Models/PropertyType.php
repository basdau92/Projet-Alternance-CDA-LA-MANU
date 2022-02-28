<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Models\PropertyCategory;

 class PropertyType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_property_category',
        'name', 
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
    protected $table = 'property_type';

    /**
     * Relationship with the PropertyCategory model table. 
     */
    public function hasOnePropertyCategories(){
        return $this->hasOne(PropertyCategory::class, 'id_property_category', 'id');
    }
}
