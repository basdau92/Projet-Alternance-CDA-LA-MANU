<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Heater extends Model
{
    protected $table = 'heater';

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
     * Relationship "inversed One To One" with the Heater model table. 
     */
    public function Heater(){
        return $this->belongsTo(Heater::class);
    }

}
