<?php

namespace App\Models;

use App\Models\Property;
use Illuminate\Database\Eloquent\Model;

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
     * Relationship "inversed One To One" with the Kitchen model table. 
     */
    public function Kitchen(){
        return $this->belongsTo(Property::class);
    }
}
