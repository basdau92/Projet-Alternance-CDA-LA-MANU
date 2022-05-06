<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class Kitchen extends Model
{
    protected $table = 'kitchen';

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
     * Relationship "inversed One To One" with the Property model table. 
     */
    public function property(){
        return $this->belongsTo(Property::class, 'id_kitchen');
    }
}
