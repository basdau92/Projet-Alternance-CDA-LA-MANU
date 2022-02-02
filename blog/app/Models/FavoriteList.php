<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FavoriteList extends Model
{
    protected $table = 'favorite_list';

    public function favoriteList()
    {
        $favorites = DB::table('favorite_list')
                         ->leftJoin('client', 'favorite_list.id_client', '=', 'client.id')
                         ->leftJoin('property', 'favorite_list.id_property', '=', 'property.id')
                         ->get();
    }
}
