<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class BillService{

    public function getBillByUser(User $user){
        return Bill::where('user_id', $user->id)->select('id','title','description','value','number_installment','payment_method','responsible','status')->get();
    }

    public function storeBill(User $user, Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:30',
            'description' => 'sometimes|string|max:50',
            'value' => 'required',
            'number_installment' => 'required',
            'payment_method' => 'required|in:DebitCard,CreditCard,Pix',
            'status' => 'required|in:Paid,Partially_Paid,Open'
        ],[
            '*.required' => 'O campo :attribute é obrigatório',
            '*.max' => 'O campo :attribute deve possuir no máximo :max caractéres',
            '*.in' => 'Apenas os seguintes valores são válidos: :values'
        ], [
            'title' => 'Título',
            'description' => 'Descrição',
            'value' => 'Valor',
            'number_installment' => 'Quantidade de Parcelas',
            'payment_method' => 'Tipo do cartão',
        ]);

        if($validator->fails()){
            throw new ValidationException($validator);
        }

        return Bill::create([
            'user_id' => $user->id,
            ...$validator->validated()
        ]);
    }
}
