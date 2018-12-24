<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
//use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //如果不被允许的路由
//        if ($e instanceof HttpException) {
//            $code = $e->getStatusCode();
//            if (view()->exists('errors.' . $code)) {
//                $message  = $e->getMessage();
//                return response()->view('errors.' . $e->getStatusCode(), ['message'=>$message], $e->getStatusCode());
//            }
//        }
        return parent::render($request, $exception);
    }
}
