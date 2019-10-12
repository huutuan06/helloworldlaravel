<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Handle HTTP Response
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
            if ($exception->getPrevious() == null) {
                // If API request and didn't attach Token and we announce error Token is not provided
                return response()->json(
                    [
                        'error' => [
                            'code' => $exception->getStatusCode(),
                            'message' => 'Token is not provided'
                        ],
                        'data' => null,
                    ],
                    $exception->getStatusCode()
                );
            } else {
                switch (get_class($exception->getPrevious())) {
                    // If API request and didn't attach Token and we announce error Token is expired
                    case \Tymon\JWTAuth\Exceptions\TokenExpiredException::class:
                        return response()->json(
                            [
                                'error' => [
                                    'code' => $exception->getStatusCode(),
                                    'message' => 'Token has expired'
                                ],
                                'data' => null,
                            ],
                            $exception->getStatusCode()
                        );
                    // If API request and didn't attach Token and we announce error Token is invalid
                    case \Tymon\JWTAuth\Exceptions\TokenInvalidException::class:
                    case \Tymon\JWTAuth\Exceptions\TokenBlacklistedException::class:
                        return response()->json(
                            [
                                'error' => [
                                    'code' => $exception->getStatusCode(),
                                    'message' => 'Token is invalid'
                                ],
                                'data' => null,
                            ],
                            $exception->getStatusCode()
                        );
                    default:
                        // If API request and didn't attach Token and we announce error Token is not provide
                        return response()->json(
                            [
                                'error' => [
                                    'code' => $exception->getStatusCode(),
                                    'message' => 'Token is not provided'
                                ],
                                'data' => null,
                            ],
                            $exception->getStatusCode()
                        );
                }
            }
        } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return response()->json(
                [
                    'error' => [
                        'code' => $exception->getStatusCode(),
                        'message' => 'Token has expired'
                    ],
                    'data' => null,
                ],
                $exception->getStatusCode()
            );
        } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            // If user find any url not existed => Load View 404 to show error.
            return \Response::view('errors.404',array(),404);
        }
        return parent::render($request, $exception);
    }

    /**
     * If user expire their session and navigate to Login Form.
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $guard = array_get($exception->guards(), 0);
        switch ($guard) {
            default:
                $login = 'login';
                break;
        }
        return redirect()->guest(route($login));
    }
}
