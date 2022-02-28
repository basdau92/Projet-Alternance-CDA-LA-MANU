<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class EnergyAudit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'path',
        'alt',
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
     * Define table that should be used by the model.  
     */
    protected $table = 'energy_audit';

    /**
     * Relationship with the PropertyType model table. 
     */
    public function belongsToProperty(){
        return $this->belongsTo(Property::class, 'id_energy_audit', 'id');
    }
}
