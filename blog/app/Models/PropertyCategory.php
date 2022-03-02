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
        'updated_at',
        'laravel_through_key'
    ];

    /**
     * Define table that should be used by the model.  
     */
    protected $table = 'property_category';

    /**
     * Relationship "inversed One To Many" with the PropertyType model table. 
     */
    public function PropertyCategories(){
        return $this->belongsTo(PropertyType::class);
    }
}
