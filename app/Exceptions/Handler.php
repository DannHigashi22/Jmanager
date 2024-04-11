<?php

namespace App\Exceptions;

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
        //
    }


    public function render($request, Throwable $exception)
    {
            if ($this->isHttpException($exception)) {
                if ($exception->getCode() == 404) {
                    return response()->view('errors.404', [], 404);
                }
                if ($exception->getCode() == 500) {
                    return response()->view('errors.500', [], 500);
                }
            }
            return parent::render($request, $exception);
         }
}
