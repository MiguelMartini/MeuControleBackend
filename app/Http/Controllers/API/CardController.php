<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Services\CardService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;

use function PHPUnit\Framework\isEmpty;

class CardController extends Controller
{
    public function __construct(
        private CardService $cardService
    ) {}

    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encontrado'
            ], 400);
        }

        $cards = $this->cardService->getCardsByUser($user);

        if ($cards->isEmpty()) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Nenhum Cartão cadastrado ainda.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 'Sucesso',
            'data' => $cards
        ], 200);
    }
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encontrado'
            ], 400);
        }

        try {
            $card = $this->cardService->storeCard($user, $request);

            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Cartão cadastrado com sucesso',
                'data' => $card->only(['title', 'description', 'card_type'])
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'Falha',
                'message' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Erro ao buscar usuário'
            ], 404);
        }
        try {
            $card = $this->cardService->getCardById($id, $user->id);

            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Cartão carregado com sucesso',
                'data' => $card->only(['id', 'title', 'description', 'card_type'])
            ], 200);
        } catch (ModelNotFoundException  $e) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Cartão não encontrado'
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
         $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encontrado'
            ], 400);
        }

        try{
            $card = $this->cardService->updateCard($id, $request);

            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Cartão atualizado com sucesso',
                'data' => $card
            ], 200);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Cartão não encontrado'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
       $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Erro ao buscar usuário'
            ], 404);
        }

        try{
            $this->cardService->deleteCard($id, $user->id);

            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Cartão excluído com sucesso'
            ], 200);
        }catch (ModelNotFoundException  $e) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Cartão não encontrado'
            ], 404);
        }
    }
}
