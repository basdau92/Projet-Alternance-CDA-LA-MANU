<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Models\RoomType;

class Room extends Model
{
    protected $table = 'room';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_property',
        'id_room_type',
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
     * Relationship "One To One" with the RoomType model table. 
     */
    public function RoomType(){
        return $this->hasOne(RoomType::class);
    }
}
