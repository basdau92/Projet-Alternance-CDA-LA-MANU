<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteList extends Model
{
    protected $table = 'favorite_list';

    /**
     * get the favorite's properties list
     */
    public function hasManyProperties()
    {
        return $this->hasMany(Property::class , 'favorite_list.id_property', 'id_client');
    }

    // public function favoriteList()
    // {
    //     $favorites = DB::table('favorite_list')
    //                      ->leftJoin('client', 'favorite_list.id_client', '=', 'client.id')
    //                      ->leftJoin('property', 'favorite_list.id_property', '=', 'property.id')
    //                      ->get();
    // }
}
