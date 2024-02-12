<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getAllLocations(Request $request)
    {
        $locations = User::find($request->user()['id'])->locations;
        return response()->json($locations, 200);
    }

    public function createLocation(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        $newLocation = new Location([
            'name' => $request['name'],
            'longitude' => $request['longitude'],
            'latitude' => $request['latitude'],
        ]);
        $user = User::find($request->user()['id']);
        if (!$user) {
            return request()->json(['message' => 'Bad request.'], 400);
        }
        $user->locations()->save($newLocation);
        return response()->json($newLocation, 200);
    }
}
