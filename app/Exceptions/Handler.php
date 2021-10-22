<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')){
                $class = get_class($e);
                switch ($class){
                    case NotFoundHttpException::class:
                    case ModelNotFoundException::class:
                        return response()->json([
                            'error' => 'Page not found 404 '.request()->url()
                        ], 404);
                    case AuthenticationException::class:
                        return response()->json([
                            'error' => $e->getMessage()
                        ], 401);
                    case ValidationException::class:
                        return response()->json([
                            'errors' => $e->validator->errors()
                        ], 402);
                    default:
                        return response()->json([
                            'error' => $e->getMessage()
                        ], 402);
                }
            }
        });
    }
}
