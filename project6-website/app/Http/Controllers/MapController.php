<?php

namespace App\Http\Controllers;

use App\Models\Location;

use GeoPHP\PGRouting\PGRouting;
use Illuminate\Http\Request;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class MapController extends Controller
{
    public function showMap()
    {
        $locations = Location::take(3)->get();
        return view('contact', compact('locations'));
    }

    // public function getRoute(Request $request, $lat1, $lng1, $lat2, $lng2)
    // {
    //     $start = new Point($lat1, $lng1);
    //     $end = new Point($lat2, $lng2);

    //     $route = PGRouting::calculateRoute($start, $end);

    //     return response()->json($route);
    // }
}
