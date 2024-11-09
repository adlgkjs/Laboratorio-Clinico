<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->input('usuario'),
            'password' => $request->input('contraseña'),
        ];

        if (Auth::attempt($credentials)) {
            // $user = Auth::user();
            // $token = $user->createToken('userToken')->plainTextToken;
            // return response()->json(['message' => 'Login exitoso', 'token' => $token, 'usuario' => $user], 200);
            return response()->json(['message' => 'Login exitoso'], 200);
        }
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Logout exitoso'], 200);
    }
}
