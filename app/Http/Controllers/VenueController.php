<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function getSedesByProvince($provinceId)
{
    $venues = \App\Models\Venue::where('province_id', $provinceId)->get();

    return response()->json($venues);
}

}
