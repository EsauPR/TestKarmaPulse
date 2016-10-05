<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Moloquent;
use App\Models\Search;

class Tweet extends Moloquent
{
    protected $collection = 'tweets';
    protected $primaryKey = '_id';
    protected $dates = ['postedTime'];
    public $timestamps = false;

    /**
     * Obtiene la búsqueda a la que pertence el tweet
     */
    public function search()
    {
        return $this->belongsTo(Search::class, 'busquedaId', '_id');
    }
}
