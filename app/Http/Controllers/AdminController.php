<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users(Request $request)
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function giveAdminRole(Request $request, string $id)
    {
        $candidate = User::find($id); 
        if (!$candidate) {
            return response()->json(['message' => 'Такого пользователя нет'], 400);
        }
        $candidate->role = 'ADMIN';
        $candidate->save();
        return response()->json(['message' => 'Вы дали пользователю админские права'], 200);
    }
}
