<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        /*\Illuminate\Auth\Access\AuthorizationException::class,
         \Symfony\Component\HttpKernel\Exception\HttpException::class,
         \Illuminate\Database\Eloquent\ModelNotFoundException::class,
         \Illuminate\Validation\ValidationException::class,*/
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
     *
     * 记录异常并将其发送给外部服务如 Bugsnag 或 Sentry, 等.
     * report 方法只是将异常传递给异常被记录的基类
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * 负责将给定异常转化为发送给浏览器的 HTTP 响应.
     * 异常被传递给为你生成响应的基类
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
