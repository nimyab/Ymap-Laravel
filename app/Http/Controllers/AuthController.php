<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function registration(Request $request)
    {
        $request->validate([
            'login' => ['required'],
            'password' => ['required', 'min:6', 'max:30'],
        ]);


        $candidates = User::all()->where('login', $request['login']);
        if (count($candidates) !== 0) {
            return response()->json(['message' => 'Пользователь с таким логином есть'], 400);
        }
        $user = User::create([
            'login' => $request['login'],
            'password' => Hash::make($request['password']),
        ]);
        return response()->json(['message' => 'Вы успесшно зарегистрировались'], 200);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'login' => ['required'],
            'password' => ['required', 'min:6', 'max:30'],
        ]);

        $users = User::all()->where('login', $request['login']);
        $user = null;
        foreach ($users as $value) {
            $user = $value;
        }

        if (count($users) === 0) {
            return response()->json(['message' => 'Пользователя с таким логином нет'], 400);
        }

        $passwordIsCorrect = Hash::check($request['password'], $user['password']);
        if (!$passwordIsCorrect) {
            return response()->json(['message' => 'Неверный пароль'], 400);
        }

        $access_tokens = $user->createToken('access-token')->plainTextToken;
        return response()->json([
            'id' => $user['id'],
            'login' => $user['login'],
            'role' => $user['role'],
            'token' => $access_tokens,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Выход был успешно совершен'], 200);
    }
}
