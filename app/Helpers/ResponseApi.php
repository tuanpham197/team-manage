<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\HttpCodeEnum;
use Illuminate\Http\JsonResponse;

class ResponseApi
{
    /**
     * Response success
     *
     * @param  array  $data
     */
    public static function responseSuccess($data, int $statusCode = HttpCodeEnum::HTTP_OK, string $message = ''): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'code' => $statusCode,
        ])->setStatusCode($statusCode);
    }

    /**
     * Response fail
     *
     * @param  array | string  $errors
     */
    public static function responseFail($errors, int $statusCode = HttpCodeEnum::HTTP_BAD_REQUEST, string $message = ''): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code' => $statusCode,
            'errors' => $errors,
        ])->setStatusCode($statusCode);
    }
}
