<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisclaimerRequest;
use App\Http\Resources\DisclaimerResource;
use App\Models\Disclaimer;
use Illuminate\Http\JsonResponse;

class DisclaimerController extends Controller
{
    public function index(): JsonResponse {
        $disclaimers = $this->paginateOrGet(Disclaimer::latest());

        return $this->respondWithResourceCollection(
            DisclaimerResource::collection($disclaimers)
        );
    }

    /**
     * Store a newly created disclaimer in storage.
     */
    public function store(DisclaimerRequest $request): JsonResponse {
        $disclaimer = Disclaimer::create($request->validated());

        return $this->respondCreated(
            new DisclaimerResource($disclaimer),
            "Disclaimer created successfully!"
        );
    }

    /**
     * Display the specified disclaimer.
     */
    public function show(Disclaimer $disclaimer): JsonResponse {
        return $this->respondWithResource(new DisclaimerResource($disclaimer));
    }

    /**
     * Update the specified disclaimer in storage.
     */
    public function update(DisclaimerRequest $request, Disclaimer $disclaimer): JsonResponse {
        $disclaimer->update($request->validated());

        return $this->respondUpdated(
            new DisclaimerResource($disclaimer),
            "Disclaimer updated successfully!"
        );
    }

    /**
     * Remove the specified disclaimer from storage.
     */
    public function destroy(Disclaimer $disclaimer): JsonResponse {
        $disclaimer->delete();

        return $this->respondSuccess("Disclaimer deleted successfully!");
    }
}
