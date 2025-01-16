<?php

namespace App\Http\Controllers;

use App\Models\Influencer;
use Illuminate\Http\Request;

class InfluencerController extends Controller
{
    /**
     * Criar um novo influenciador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'instagram_username' => 'required|string|unique:influencers,instagram_username|max:255',
            'followers_count' => 'required|integer|min:1',
            'category' => 'required|string|max:255',
        ]);

        // Cria o influenciador com os dados validados
        $influencer = Influencer::create($validated);

        return response()->json($influencer, 201);
    }

    /**
     * Listar todos os influenciadores.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $influencers = Influencer::all();
        return response()->json($influencers);
    }

    /**
     * Listar as campanhas de um influenciador específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function campaigns($id)
    {
        // Verifica se o influenciador existe
        $influencer = Influencer::findOrFail($id);

        // Retorna as campanhas do influenciador
        return response()->json($influencer->campaigns);
    }
}
