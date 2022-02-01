<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'property';

    public function getAllProperties() {
        foreach (Property::all() as $property) {
            echo $property->name;
        }
    }
}
