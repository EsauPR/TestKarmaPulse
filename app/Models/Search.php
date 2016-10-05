<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Moloquent;
use App\Models\Tweet;

class Search extends Moloquent
{
    protected $collection = 'busquedas';
    protected $primaryKey = '_id';

    public $timestamps = false;

    /**
     * Obtiene los tweets de una búsqueda
     */
    public function tweets()
    {
        return $this->hasMany(Tweet::class, 'busquedaId', '_id');
    }
}
