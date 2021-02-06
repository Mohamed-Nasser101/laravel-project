<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
    }

    public function render($request,Throwable $e)
    {
        if ($e instanceof ModelNotFoundException && $request->expectsJson()){
          //  return  response()->redirectToRoute('api.fallback');
            return response()->json(['message' => 'not found'],404);
        }

        if ($request->expectsJson() && $e instanceof AuthorizationException){
            return response()->json(['message' => $e->getMessage()],403);
        }
        return parent::render($request, $e);
    }
}
