<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class FavoriteList extends Model
{
    protected $table = 'favorite_list';
   
    /**
     * get the properties for the favorite's list
     */
    public function favoriteList()
    {
        return $this->belongsTo(Property::class,'id_property','id');
    }
}
