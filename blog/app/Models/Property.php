<?php

namespace App\Models;

use App\Models\FavoriteList;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'property';

    public function belongsToFavoriteList()
    {
        return $this->hasMany(FavoriteList::class, 'id_property', 'id');
    }
}
