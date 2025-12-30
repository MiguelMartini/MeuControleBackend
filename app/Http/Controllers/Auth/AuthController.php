<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
         $validator = Validator::make($request->all(), [
            'email'=> 'required|unique:users,email',
            'name' => 'required|string',
            'password' => 'required|min:8|confirmed',
            'profile_picture' => 'nullable|string'
         ], [
            '*.required' => 'Campo obrigatório',
            'email.unique'=> 'E-mail existente',
            'password.min'=> 'A senha deve conter pelo menos 8 caracteres',
            'password.confirmed'=> 'As senhas devem ser iguais'
         ]);

         if($validator->fails()){
            return response()->json([
                'status' => 'Falha',
                'message' => $validator->errors()
            ], 400);
         }

         $data = $request->all();

         User::create($data);

         return response()->json([
            'status' => 'Sucesso',
            'message' => 'Usuário registrado com sucesso!'
         ], 201);
    }
}
