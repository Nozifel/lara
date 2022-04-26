<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="ROC API", version="1.0.0")
 */

class DefaultController extends Controller
{
    /**
     * @OA\Get(
     *     path="/sanctum/csrf-cookie",
     *     tags={"Auth"},
     *     summary="Demande d'un cookie CSRF",
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function getCSRF() {}

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Auth"},
     *     summary="Connexion à l'API",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *          )
     *     ),
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function login() {}

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"Auth"},
     *     summary="Deconnexion de l'API",
     *     security={ {"sanctum": {} }},
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function logout() {}
}
