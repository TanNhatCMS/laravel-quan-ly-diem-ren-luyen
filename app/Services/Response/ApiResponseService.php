<?php

namespace App\Services\Response;

use Illuminate\Http\JsonResponse;

class ApiResponseService
{
    /**
     * Return a success response.
     */
    public static function success(
        mixed $data = null,
        string $message = null,
        int $statusCode = 200,
        array $headers = []
    ): JsonResponse {
        $response = [
            'status' => true,
            'data' => $data,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, $statusCode, $headers);
    }

    /**
     * Return an error response.
     */
    public static function error(
        string $message = 'Something went wrong',
        mixed $data = null,
        int $statusCode = 400,
        array $headers = []
    ): JsonResponse {
        $response = [
            'status' => false,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode, $headers);
    }

    /**
     * Return a validation error response.
     */
    public static function validationError(
        array $errors,
        string $message = 'Validation failed',
        int $statusCode = 422
    ): JsonResponse {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }

    /**
     * Return a not found response.
     */
    public static function notFound(
        string $message = 'Resource not found'
    ): JsonResponse {
        return self::error($message, null, 404);
    }

    /**
     * Return an unauthorized response.
     */
    public static function unauthorized(
        string $message = 'Unauthorized'
    ): JsonResponse {
        return self::error($message, null, 401);
    }

    /**
     * Return a forbidden response.
     */
    public static function forbidden(
        string $message = 'Forbidden'
    ): JsonResponse {
        return self::error($message, null, 403);
    }
}