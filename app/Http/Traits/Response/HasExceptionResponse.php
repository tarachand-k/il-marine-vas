<?php

namespace App\Http\Traits\Response;

use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait HasExceptionResponse
{
    use HasBaseResponse;

    public function respondQueryException(
        QueryException $exception,
        string $message = "There was an issue with the database query",
        int $statusCode = 500,
    ): JsonResponse {
        return $this->apiResponse([
            "success" => false,
            "message" => $message,
            "exception" => $exception
        ], $statusCode);
    }

    public function respondValidationErrors(ValidationException $exception): JsonResponse {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
                'exception' => $exception,
            ],
            422
        );
    }

    public function respondForbidden($message = "Forbidden"): JsonResponse {
        return $this->respondError($message, statusCode: 403);
    }

}
