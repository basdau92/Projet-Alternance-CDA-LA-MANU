<?php

namespace App\Models;

use App\Models\Rdv;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'label';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationship "Inversed One To Many" with the Rdv model table.
     */
    public function rdv()
    {
        return $this->belongsTo(Rdv::class, 'id_label', 'id');
    }
}
