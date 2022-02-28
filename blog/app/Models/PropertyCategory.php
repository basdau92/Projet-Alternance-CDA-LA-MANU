<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyType;

class PropertyCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
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
    protected $table = 'property_category';

    /**
     * Relationship with the PropertyType model table. 
     */
    public function belongsToPropertyType(){
        return $this->belongsTo(PropertyType::class, 'id_property_category', 'id');
    }
}
