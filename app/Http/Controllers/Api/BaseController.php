<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * Success Response.
     *
     * @param  mixed|null  $data
     * @param  int  $code
     * @param  array  $headers
     * @return JsonResponse
     */
    protected function successResponse(mixed $data = null, int $code = 200, array $headers = [])
    {
        $content = [
            'status' => true,
            'data' => $data,
        ];

        return response()->json($content, $code, $headers);
    }

    /**
     * Failed Response.
     *
     * @param  string|null  $message
     * @param  mixed|null  $data
     * @param  int  $code
     * @param  array  $headers
     * @return JsonResponse
     */
    protected function failedResponse(
        ?string $message = null,
        mixed $data = null,
        int $code = 400,
        array $headers = []
    ) {
        $content = [
            'status' => false,
            'data' => $data,
            'message' => $message ?? 'Something went wrong!',
        ];

        return response()->json($content, $code, $headers);
    }

    /**
     * return error response.
     *
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (! empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * success response method.
     *
     * @return JsonResponse
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }
}
