<?php

namespace App\Http\Traits\Response;

//use App\Http\Resources\Ghost\EmptyResource;
//use App\Http\Resources\Ghost\EmptyResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait HasApiResponse
{
    use HasBaseResponse;

    public function respondCreated($data, $message = "Resource created successfully"): JsonResponse {
        return $this->respondSuccess($message, $data, 201);
    }


    public function respondUpdated($data, $message = "Resource updated successfully"): JsonResponse {
        return $this->respondSuccess($message, $data);
    }

    public function respondAuthenticated(
        string $token,
        $message,
        mixed $data = null,
        $statusCode = 200,
        $headers = []
    ): JsonResponse {
        return $this->apiResponse([
            "success" => true,
            "message" => $message,
            "token" => $token,
            "data" => $data,
        ], $statusCode, $headers);
    }

    public function respondWithResource(
        JsonResource|array $resource,
        $statusCode = 200,
        $headers = []
    ): JsonResponse {
        return $this->respondSuccess(null, $resource, $statusCode, $headers);
    }

    public function respondWithResourceCollection(
        ResourceCollection|array $resourceCollection,
        $statusCode = 200,
        $headers = []
    ): JsonResponse {
        $collection = $resourceCollection->response()->getData();

        return
            $this->apiResponse([
                "success" => true,
                "message" => null,
                "data" => $collection->data,
                "links" => $collection?->links ?? null,
                "meta" => $collection?->meta ?? null
            ],
                $statusCode,
                $headers
            );
    }

}


