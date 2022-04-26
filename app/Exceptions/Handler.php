<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Router;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    /*public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return new JsonResponse([
                'message' => 'Record not found.'
            ], 404);
        });

        $this->renderable(function (ModelNotFoundException $e, $request) {
            return new JsonResponse([
                'message' => 'Record not found.'
            ], 404);
        });

        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/auth/*')) {
                return new JsonResponse([
                    'message' => $e->getMessage(),
                    'errors' => $e->errors()
                ], 400);
            }
        });

        $this->renderable(function (AuthorizationException $e, $request) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], 201);
        });
    }

    public function render($request, Throwable $e)
    {
        $renderables = [
            TokenMismatchException::class,
            AuthenticationException::class,
            AuthorizationException::class
        ];
        
        if( in_array($e::class, $renderables) )
        {
            if( method_exists($e, 'errors') )
            {
                return new JsonResponse([
                    "message" => $e->getMessage(),
                    "errors" => $e->errors()
                ], 200);
            }

            return new JsonResponse([
                "message" => $e->getMessage()
            ], 200);
        }

        return parent::render($request, $e);
    }*/

    public function render($request, Throwable $e)
    {
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($e);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        /*} elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);*/
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $request->expectsJson()
                        ? $this->prepareJsonResponse($request, $e)
                        : $this->prepareJsonResponse($request, $e);
    }

    protected function prepareException(Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new AccessDeniedHttpException($e->getMessage(), $e);
        } elseif ($e instanceof TokenMismatchException) {
            $e = new HttpException(419, $e->getMessage(), $e);
        }

        return $e;
    }
}
