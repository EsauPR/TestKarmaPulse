<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Search;
use App\Models\Tweet;
use \DateTime;

class Test extends Controller
{
    public function index()
    {
        //return Search::all()->first()->tweets()->get();
        //return dd(Tweet::all()->first());
        //return Tweet::all()->first()->search()->get();
        //return Tweet::all()->first()->menciones;
        //return date('Y-m-d', strtotime(Tweet::all()->first()->postedTime));
        $date = Tweet::all()->first()->postedTime;
        //$date->modify( '+1 day' );
        //return $date;
        return Tweet::where('postedTime', '<=', new DateTime('2015-07-09 +1 day'))
            ->where('postedTime', '>=', new DateTime('2015-07-09'))->get();
        //$utcdatetime = new \MongoDB\BSON\UTCDateTime($date);
        //return [$utcdatetime->toDateTime(), $date];

    }
}
