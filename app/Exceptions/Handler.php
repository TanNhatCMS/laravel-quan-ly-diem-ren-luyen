<?php

namespace App\Exceptions;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Exceptions\Auth\TokenException;
use App\Exceptions\User\UserDeletionException;
use App\Exceptions\User\UserNotFoundException;
use App\Services\Response\ApiResponseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        InvalidCredentialsException::class,
        TokenException::class,
        UserNotFoundException::class,
        UserDeletionException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Handle API requests
        if ($request->is('api/*') || $request->expectsJson()) {
            return $this->handleApiException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Handle API exceptions with standardized JSON responses.
     */
    protected function handleApiException(Request $request, Throwable $exception): JsonResponse
    {
        // Custom exceptions
        if ($exception instanceof InvalidCredentialsException) {
            return ApiResponseService::unauthorized($exception->getMessage());
        }

        if ($exception instanceof TokenException) {
            return ApiResponseService::unauthorized($exception->getMessage());
        }

        if ($exception instanceof UserNotFoundException) {
            return ApiResponseService::notFound($exception->getMessage());
        }

        if ($exception instanceof UserDeletionException) {
            return ApiResponseService::forbidden($exception->getMessage());
        }

        // Laravel built-in exceptions
        if ($exception instanceof ValidationException) {
            return ApiResponseService::validationError(
                $exception->errors(),
                'The given data was invalid.',
                422
            );
        }

        if ($exception instanceof AuthorizationException) {
            return ApiResponseService::forbidden('This action is unauthorized.');
        }

        if ($exception instanceof NotFoundHttpException) {
            return ApiResponseService::notFound('The requested resource was not found.');
        }

        if ($exception instanceof ModelNotFoundException) {
            return ApiResponseService::notFound('The requested resource was not found.');
        }

        // Generic server error
        return ApiResponseService::error(
            config('app.debug') ? $exception->getMessage() : 'Internal server error',
            null,
            500
        );
    }

    protected function whoopsHandler()
    {
        try {
            return app(\Whoops\Handler\HandlerInterface::class);
        } catch (\Illuminate\Contracts\Container\BindingResolutionException $e) {
            return parent::whoopsHandler();
        }
    }
}
