<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function postLoginApi() {
        $user = User::all();

        if($user->isEmpty()){
            $data = [
                'message' => 'No se encontraron usuarios',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($user, 200);

    }

    public function postLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]); 

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de datos',
                'error' => $validator->errors(),
                'status' => false
            ];

            return response()->json($data, 422);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            
            return response()->json([
                'status' => true,
                'message' => 'Login Exitoso',
                'user' => Auth::user()
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Las credenciales no coinciden'
        ], 401);
    }


    public function postRegister(Request $request){
    
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de datos',
                'error' => $validator->errors(),
                'status' => false
            ];

            return response()->json($data, 422);
        }

        $usuario = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone' => $request->phone
        ]);

        if(!$usuario){
            $data = [
                'message' => 'Error al crear nuevo usuario',
                'error' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Usuario Creado con exito',
            'data' => $usuario,
            'status' => true
        ];

        return response()->json($data, 201);
    }    
}
