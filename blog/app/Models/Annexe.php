<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FeaturesList;

class Annexe extends Model
{
    protected $table = 'annexe';

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
     * Relationship "inversed One To Many" with the FeaturesList model table. 
     */
    public function Annexes(){
        return $this->belongsTo(FeaturesList::class);
    }
}
