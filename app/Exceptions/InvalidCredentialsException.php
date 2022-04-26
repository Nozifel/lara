<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InvalidCredentialsException extends Exception
{
    public function render($request)
    {
        return new JsonResponse(
            [
                'message' => [
                    'Invalid credentials'
                ]
            ],
            200
        );
    }
}
