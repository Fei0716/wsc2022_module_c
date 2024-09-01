<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        //check for invalid or missing auth header
        $this->renderable(function(AuthenticationException $e , Request $request){
            if ($request->is('api/v1/*')) {
                //no header
                if(!$request->headers->get("Authorization")){
                    return response()->json([
                        "status" => "unauthenticated",
                        "message" => "Missing token"
                    ]);
                }

                // invalid token
                return response()->json([
                    'status' => 'unauthenticated',
                    'message' => 'Invalid token',
                ], 401);
            }
        });

        //check for bad requests
        $this->renderable(function(ValidationException $e , Request $request){
            return response()->json([
                "status" => "invalid",
                "message" => "Request body is not valid",
                "violations" => $e->errors(),
            ], 400);
        });

        //check for not found exception
        $this->renderable(function(NotFoundHttpException $e , Request $request){
            if ($request->is('api/v1/*')) {
                return response()->json([
                    "status" => "not-found",
                    "message" => "Not found",
                ]);
            }

        });
    }
}
