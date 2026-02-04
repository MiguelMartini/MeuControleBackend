<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\BillService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BillController extends Controller
{
    public function __construct(
        private BillService $billService
    )
    {}
    public function index()
    {
        $user = Auth::user();

        if(!$user) { 
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        $bills = $this->billService->getBillByUser($user);

        if($bills->isEmpty()){
            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Nenhuma conta registrada',
                'data' => []
            ],200);
        }

        return response()->json([
            'status' => 'Sucesso',
            'data' => $bills
        ], 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if(!$user) {
            return response()-> json([
                'status' => 'Falha', 
                'message' => 'Usuário não encontrado ou não registrado'
            ], 404);
        }

        try{
            $bill = $this->billService->storeBill($user, $request);

            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Conta registrada com sucesso!',
                'data' => $bill
            ], 201);
        }catch(ValidationException $e){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Não foi possível registrar sua conta no momento, tente novamente mais tarde',
                'data' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
