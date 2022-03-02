<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FeaturesList;

class Hygiene extends Model
{
    protected $table = 'hygiene';

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
        'updated_at',
        'laravel_through_key'
    ];

    /**
     * Relationship "inversed One To Many" with the FeaturesList model table. 
     */
    public function Hygienes(){
        return $this->belongsTo(FeaturesList::class);
    }
}
