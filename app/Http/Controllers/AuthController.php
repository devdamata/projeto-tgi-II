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
            return [
                'message' => 'Erro ao criar usuário.'
            ];
        }

        $token = $user->createToken($request->name);

        $cookie = cookie(
            'authToken',
            $token->plainTextToken,
            1440,
            '/',
            null,
            true,
            true,
            false,
            'strict'
        );

        return response()->json(
            [
                'message' => 'Usuário criado com sucesso.',
                'user' => $user,
            ]
        )->cookie($cookie);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'message' => 'Credenciais inválidas. Verifique seu e-mail e senha.'
                ], 401
            );
        }

        $token = $user->createToken($user->name);

        $cookie = cookie(
            'authToken',
            $token->plainTextToken,
            1440,
            '/',
            null,
            true,
            true,
            false,
            'strict'
        );

        return response()->json(
            [
                'message' => 'Login bem-sucedido',
                'user' => $user,
            ]
        )->cookie($cookie);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Deslogado.'
        ];
    }
}
