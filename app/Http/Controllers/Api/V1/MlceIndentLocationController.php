<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MlceIndentLocationRequest;
use App\Http\Resources\MlceIndentLocationResource;
use App\Models\MlceIndentLocation;
use Illuminate\Http\JsonResponse;

class MlceIndentLocationController extends Controller
{
    protected array $relations = [
        "mlceIndent"
    ];

    public function index(): JsonResponse {
        $mlceIndentLocations = $this->paginateOrGet(
            MlceIndentLocation::with($this->getRelations())->latest());

        return $this->respondWithResourceCollection(
            MlceIndentLocationResource::collection($mlceIndentLocations)
        );
    }

    /**
     * Store a newly created mlceIndentLocation in storage.
     */
    public function store(MlceIndentLocationRequest $request): JsonResponse {
        $mlceIndentLocation = MlceIndentLocation::create($request->validated());

        return $this->respondCreated(
            new MlceIndentLocationResource($mlceIndentLocation),
            "MLCE Indent Location created successfully!"
        );
    }

    /**
     * Display the specified mlceIndentLocation.
     */
    public function show(MlceIndentLocation $mlceIndentLocation): JsonResponse {
        $mlceIndentLocation->loadMissing($this->getRelations());

        return $this->respondWithResource(
            new MlceIndentLocationResource($mlceIndentLocation));
    }

    /**
     * Update the specified mlceIndentLocation in storage.
     */
    public function update(MlceIndentLocationRequest $request, MlceIndentLocation $mlceIndentLocation): JsonResponse {
        $mlceIndentLocation->update($request->validated());

        return $this->respondUpdated(
            new MlceIndentLocationResource($mlceIndentLocation),
            "MLCE Indent Location updated successfully!"
        );
    }

    /**
     * Remove the specified mlceIndentLocation from storage.
     */
    public function destroy(MlceIndentLocation $mlceIndentLocation): JsonResponse {
        $mlceIndentLocation->delete();

        return $this->respondSuccess("MLCE Indent Location deleted successfully!");
    }
}
