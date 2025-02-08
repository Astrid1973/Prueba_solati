<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   
    public function loginApi(Request $request){
            $validate = $request->validate([
                'email' => 'required|email',
                'password'=> 'required'
            ]);
            
            if(!Auth::attempt($validate)){
                return response()->json(['Message'=>'Autenticación fallida'],500);
            }
            $user = Auth::user();
            
            $existingToken = $user->tokens()->where('name', 'auth_token')->first();

            if ($existingToken) {
               
                return response()->json([
                    'message' => 'Ya has iniciado sesion',
                    'access_token' => $existingToken->plainTextToken,
                    'token_type' => 'Bearer'
                ], 200);
                exit();
            }
            

            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer'
             ]);
        }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada'],200);
}

    public function me(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'error' => 'Token invalido o expirado. Por favor, inicia sesion nuevamente.'
            ], 401);
        }
        return response()->json(['user' => $request->user()],200);
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);
       /*if ($request->fails()) {
            return response()->json($request->errors(), 400);
        }
*/
        $user = User::create($request->all());

        return response()->json(['message' => 'Usuario creado con exito'],201);
    }

    public function listUsers()
    {
        $users = User::all();
        return response()->json($users, 200);
    }
}
