<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function show(string $id)
    {
        $user = FacadesAuth::user();

        if(!$user){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não autenticado'
            ],401);
        }

        if((int)$user->id !== (int)$id){
            return response()->json([
                'stauts' => 'Falha',
                'message' => 'Sem permissão para esta operação'
            ], 203);
        }

        return response()->json([
            'status' => 'Sucesso',
            'data' => $user->only(['id', 'email', 'name', 'profile_picture']) 
        ],200);
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        // dd($user);
        if(!$user){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encontrado'
            ],401);
        }

       $validator = Validator::make($request->all(), [
        'email' => 'unique:users,email',
        'name' => 'string|max:20',
        'profile_picture' => 'nullable|string',
        'current_password' => 'required'
        ], [
            '*.required' => 'Campo obrigatório',
            'email.unique'=> 'E-mail existente',
            'current_password.required' => 'Você deve informar a senha'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'falha',
                'message' => $validator->errors()
            ], 400);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Senha incorreta'
            ], 403);
        }

        $user->update($validator->validate());

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Dados atualizados com suceeso!'
        ],200);
    }
    public function destroy(string $id)
    {
        //
    }
}
