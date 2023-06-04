<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'password'
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => 'NOT_FOUND',
                    'message' => 'Resource not found',
                    'status' => 404
                ], 404);
            }
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            return response()->json([
                'code' => 'FORBIDDEN',
                'message' => 'Forbidden access',
                'status' => 403
            ], 403);
        });

        $this->renderable(function (ThrottleRequestsException $e, $request) {
            return response()->json([
                'code' => 'TOO_MANY_ATTEMPTS',
                'message' => 'Too many attempts',
                'status' => 429
            ], 429);
        });
    }
}
