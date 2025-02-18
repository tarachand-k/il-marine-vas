<?php

namespace App\Http\Traits\Response;

use Error;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait HasBaseResponse
{

    public function respondSuccess(
        string $message = null,
        mixed $data = null,
        int $statusCode = 200,
        array $headers = []
    ): JsonResponse {
        return $this->apiResponse([
            "success" => true,
            "message" => $message,
            "data" => $data
        ], $statusCode, $headers);
    }

    public function apiResponse(array $data, int $statusCode, array $headers = []): JsonResponse {
        $data = $this->parseGivenData($data, $statusCode, $headers);

        return response()->json(
            $data['content'], $data['statusCode'], $data['headers']
        );
    }

    public function parseGivenData($data = [], $statusCode = 200, $headers = []): array {
        $responseStructure = [
            'success' => $data['success']
        ];

        isset($data["message"]) && $responseStructure["message"] = $data["message"];
        isset($data["data"]) && $responseStructure["data"] = $data["data"];
        isset($data["links"]) && $responseStructure["links"] = $data["links"];
        isset($data["meta"]) && $responseStructure["meta"] = $data["meta"];
        isset($data["token"]) && $responseStructure["token"] = $data["token"];
        isset($data["errors"]) && $responseStructure["errors"] = $data["errors"];

        if (
            isset($data['exception']) &&
            ($data['exception'] instanceof Error || $data['exception'] instanceof Exception)) {

            if (config('app.env') !== 'production') {
                $exception = [
                    'message' => $data['exception']->getMessage(),
                    'file' => $data['exception']->getFile(),
                    'line' => $data['exception']->getLine(),
                    'code' => $data['exception']->getCode(),
                ];

                if ($data["exception"] instanceof QueryException) {
                    $exception["sql"] = $data["exception"]->getSql();
                    $exception['bindings'] = $data["exception"]->getBindings();
                }

                if ($data["exception"] instanceof ValidationException) {
                    $exception = [];
                }

                $responseStructure["exception"] = $exception;
            }

            $statusCode === 200 && $statusCode = 500;
        }

        return ["content" => $responseStructure, "statusCode" => $statusCode, "headers" => $headers];
    }

    public function respondUnAuthorized($message = "Unauthorized"): JsonResponse {
        return $this->respondError($message, statusCode: 401);
    }

    public function respondError(
        $message = "There was an internal error, Pls try again later",
        Exception|null $exception = null,
        int $statusCode = 500,
    ): JsonResponse {
        return $this->apiResponse(
            [
                "success" => false,
                "message" => $message,
                "exception" => $exception
            ], $statusCode
        );
    }

    public function respondNotFound($message = "Resource Not Found", $exception = null): JsonResponse {
        return $this->respondError($message, $exception, 404);
    }
}
