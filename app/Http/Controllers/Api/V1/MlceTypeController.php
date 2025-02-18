<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MlceTypeRequest;
use App\Http\Resources\MlceTypeResource;
use App\Models\MlceType;
use Illuminate\Http\JsonResponse;

class MlceTypeController extends Controller
{
    public function index(): JsonResponse {
        $mlceTypes = MlceType::all();

        return $this->respondWithResourceCollection(
            MlceTypeResource::collection($mlceTypes)
        );
    }

    /**
     * Store a newly created mlceType in storage.
     */
    public function store(MlceTypeRequest $request): JsonResponse {
        $mlceType = MlceType::create($request->validated());

        return $this->respondCreated(
            new MlceTypeResource($mlceType),
            "MlceType created successfully!"
        );
    }

    /**
     * Display the specified mlceType.
     */
    public function show(MlceType $mlceType): JsonResponse {
        return $this->respondWithResource(new MlceTypeResource($mlceType));
    }

    /**
     * Update the specified mlceType in storage.
     */
    public function update(MlceTypeRequest $request, MlceType $mlceType): JsonResponse {
        $mlceType->update($request->validated());

        return $this->respondUpdated(
            new MlceTypeResource($mlceType),
            "MlceType updated successfully!"
        );
    }

    /**
     * Remove the specified mlceType from storage.
     */
    public function destroy(MlceType $mlceType): JsonResponse {
        $mlceType->delete();

        return $this->respondSuccess("MlceType deleted successfully!");
    }
}
