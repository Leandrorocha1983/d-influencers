<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/api/v1/users",
 *     summary="Listar todos os usuários",
 *     description="Este endpoint retorna uma lista de todos os usuários registrados.",
 *     @OA\Response(
 *         response=200,
 *         description="Usuários encontrados",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", description="ID do usuário"),
 *                 @OA\Property(property="name", type="string", description="Nome do usuário"),
 *                 @OA\Property(property="email", type="string", description="E-mail do usuário")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Nenhum usuário encontrado"
 *     )
 * )
 */
class UserController extends Controller
{
    public function getUsers(): JsonResponse
    {
        return response()->json(User::all());
    }
}
