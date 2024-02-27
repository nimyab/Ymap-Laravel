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
            'longitude' => 'required|numeric|max:180|min:-180',
            'latitude' => 'required|numeric|max:90|min:-90',
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
            'longitude' => 'required|integer|max:180|min:-180',
            'latitude' => 'required|integer|max:90|min:-90',
        ]);

        $location = Location::find($request['id']);

        if (!Gate::allows('update-location', $location)) {
            return response()->json(['message' => 'Нет прав'], 403);
        }
        $location->update([
            'name' => $request['name'],
            'longitude' => $request['longitude'],
            'latitude' => $request['latitude'],
        ]);
        return response()->json($location, 200);
    }

    public function deleteLocation(Request $request, string $id)
    {

        $location = Location::find($id);
        if (!Gate::allows('delete-location', $location)) {
            return response()->json(['message' => 'Нет прав'], 403);
        }
        $isDeleted = $location->delete();
        return response()->json($isDeleted, 200);
    }
}
