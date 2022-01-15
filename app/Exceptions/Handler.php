<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// use Throwable;

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
    // public function report(Exception $exception)
    // {
    //     parent::report($exception);
    // }


    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    // public function render($request, Exception $exception)
    // {
    //     return parent::render($request, $exception);
    // }
    // protected function unauthenticated($request, AuthenticationException $exception){
    //     if ($request->expectsJson()) {
    //         return response()->json(['error' => 'Unauthenticated.'], 401);
    //     }
    //     if (in_array('admin', $exception->guards())) { // ここから
    //         return redirect()->guest('admin/login');
    //     } // ここまで追記
    //     return redirect()->guest(route('login'));
    // }
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
