<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Models\Employee;


class PropertyList extends Model
{
    protected $table = 'property_list';


    /**
     * Relationship "Inversed One To Many" with the Property model table. 
     */
    public function property(){
        return $this->belongsTo(Property::class, 'id_property', 'id');
    }

    /**
     * Relationship "Inversed One To One" with the RoomType model table. 
     */
    public function employee(){
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }

}
