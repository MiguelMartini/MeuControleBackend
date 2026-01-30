<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\BillService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
