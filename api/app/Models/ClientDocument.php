<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDocument extends Model
{
    protected $table = 'client_document';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_client',
        'name',
        'path'
    ];

    /**
     * get a document from a client
     */
    public function showDocument()
    {
        return $this->belongsTo(ClientDocument::class,'id_client','id');
    }
}
