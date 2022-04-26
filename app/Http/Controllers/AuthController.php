<?php

namespace App\Http\Controllers;

use App\Events\Login;
use App\Exceptions\AuthException;
use App\Exceptions\InvalidCredentialsException;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login( LoginRequest $loginRequest )
    {
        if( Auth::attempt($loginRequest->validated()) )
        {
            $loginRequest->session()->regenerate();

            $user = Auth::user();
            $user->tokens()->delete();
            $token = $user->createToken('auth');

            Login::dispatch($user);

            return new JsonResponse([
                'token' => $token->plainTextToken,
                'user' => new UserResource( $user )
            ],
            Response::HTTP_OK);
        }

        throw new InvalidCredentialsException();
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return new JsonResponse(
            [
                'data' => ["Successfully logout"]
            ]
        ,
        Response::HTTP_OK);
    }
}
