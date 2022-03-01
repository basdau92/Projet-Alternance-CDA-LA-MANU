<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class PropertyPicture extends Model
{
    protected $table = 'property_picture';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_property',
        'title',
        'path',
        'alt', 
        'order', 
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

}
