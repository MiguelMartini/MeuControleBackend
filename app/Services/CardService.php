<?php

namespace App\Services;

use App\Models\Card;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class CardService
{
    public function getCardsByUser(User $user)
    {
        return Card::where('user_id', $user->id)->select('id', 'title', 'description', 'card_type')->get();
    }

    public function storeCard(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:30',
            'description' => 'nullable|string|max:50',
            'card_type' => 'nullable|in:Debit,Credit'
        ], [
            '*.required' => 'O campo :attribute é obrigatório',
            '*.max' => 'O campo :attribute deve possuir no máximo :max caractéres',
            '*.in' => 'Apenas os seguintes valores são válidos: :values'
        ], [
            'title' => 'Título',
            'description' => 'Descrição',
            'card_type' => 'Tipo do cartão'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Card::create([
            'user_id' => $user->id,
            ...$validator->validated()
        ]);
    }

    public function getCardById(int $card_id, int $user_id)
    {
        return Card::where('id', $card_id)->where('user_id', $user_id)->firstOrFail();
    }

    public function deleteCard(int $card_id, int $user_id)
    {
        $card = Card::where('id', $card_id)->where('user_id', $user_id)->firstOrFail();
        $card->delete();
    }
}
