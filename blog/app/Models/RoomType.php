<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class RoomType extends Model
{
    protected $table = 'room_type';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name'
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
     * Relationship "inversed  One To Many" with the Room model table. 
     */
    public function RoomType(){
        return $this->belongsTo(Room::class);
    }
}
