<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LocationController extends Controller
{
    public function getAllLocations(Request $request)
    {
        $locations = $request->user()->locations;
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
        $newLocation['user_id'] = $request->user()['id'];
        $newLocation->save();
        
        return response()->json($newLocation, 200);
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        $request->user()
            ->locations()
            ->find($request['id'])
            ->update([
                'name' => $request['name'],
                'longitude' => $request['longitude'],
                'latitude' => $request['latitude'],
            ]);
        $location = Location::find($request['id']);
        return response()->json($location, 200);
    }

    public function deleteLocation(Request $request, string $id)
    {
        $user = $request->user();
        $isDeleted = $user->locations()->find($id)->delete();
        return response()->json($isDeleted, 200);
    }
}
