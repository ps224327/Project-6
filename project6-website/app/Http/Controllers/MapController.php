<?php

namespace App\Http\Controllers;
use App\Models\Location;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function showMap()
{
    $locations = Location::take(3)->get();
    return view('contact', compact('locations'));
}
    
}
