<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Http;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Cliente::all());
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
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:clientes',
            'cep' => 'required|string|size:8',
            'numero' => 'required|string|max:10',
        ]);

        // Consultar endereço na API dos Correios (ViaCEP)
        $response = Http::get("https://viacep.com.br/ws/{$request->cep}/json/");
        if ($response->failed() || isset($response['erro'])) {
            return response()->json(['error' => 'CEP inválido'], 400);
        }

        $endereco = "{$response['logradouro']}, {$response['bairro']}, {$response['localidade']}-{$response['uf']}";

        $cliente = Cliente::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'cep' => $request->cep,
            'endereco' => $endereco,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
        ]);

        return response()->json($cliente, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Cliente::findOrFail($id));
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
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());
        return response()->json($cliente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cliente::destroy($id);
        return response()->json(['message' => 'Cliente removido']);
    }
}
