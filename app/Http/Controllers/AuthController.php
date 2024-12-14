<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create($fields);

        if (!$user) {
            return response()->json([
                'message' => 'Erro ao criar usuário.',
            ], 500);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $cookie = cookie(
            'auth_token',
            $token,
            10,
            '/',
            null,
            true,
            true,
            false,
            'none'
        );

        return response()->json([
            'message' => 'Usuário criado com sucesso.',
            'user' => $user,
            'token' => $cookie->getValue()
        ])->cookie($cookie);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas. Verifique seu e-mail e senha.',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $cookie = cookie(
          'auth_token',
            $token,
          10,
            '/',
            null,
            true,
            true,
            false,
            'none'
        );

        return response()->json([
            'message' => 'Login realizado com sucesso!',
            'token' => $cookie->getValue()
        ])->cookie($cookie);
    }

    public function verifyToken(Request $request)
    {
        $token = $request->cookie('auth_token');
        if (!$token || !auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json(['message' => 'Authenticated'], 200);
    }

    public function logout(Request $request)
    {
        // Revoga todos os tokens do usuário autenticado
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Deslogado com sucesso.',
        ]);
    }
}
