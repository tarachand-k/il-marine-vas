<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MlceRecommendationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\MlceRecommendationRequest;
use App\Http\Resources\MlceRecommendationResource;
use App\Models\MlceRecommendation;
use Illuminate\Http\JsonResponse;

class MlceRecommendationController extends Controller
{
    protected array $relations = [
        "mlceAssignment"
    ];

    protected array $fileFieldNames = [
        "photo_1", "photo_2", "photo_3", "photo_4",
    ];

    protected array $fileFolderPaths = [
        "photos", "photos", "photos", "photos"
    ];

    protected ?string $resourceName = "mlce-recommendations";

    public function index(): JsonResponse {
        $mlceRecommendations = $this->paginateOrGet(MlceRecommendation::latest());

        return $this->respondWithResourceCollection(
            MlceRecommendationResource::collection($mlceRecommendations)
        );
    }

    /**
     * Store a newly created mlceRecommendation in storage.
     */
    public function store(MlceRecommendationRequest $request): JsonResponse {
        $mlceRecommendation = new MlceRecommendation($request->validated());
        $this->storeFiles($request, $mlceRecommendation);
        $mlceRecommendation->save();

        return $this->respondCreated(
            new MlceRecommendationResource($mlceRecommendation),
            "MlceRecommendation created successfully!"
        );
    }

    /**
     * Display the specified mlceRecommendation.
     */
    public function show(MlceRecommendation $mlceRecommendation): JsonResponse {
        return $this->respondWithResource(new MlceRecommendationResource($mlceRecommendation));
    }

    /**
     * Update the specified mlceRecommendation in storage.
     */
    public function update(MlceRecommendationRequest $request, MlceRecommendation $mlceRecommendation): JsonResponse {
        $mlceRecommendation->fill($request->validated());
        $this->updateFiles($request, $mlceRecommendation);
        $mlceRecommendation->save();

        return $this->respondUpdated(
            new MlceRecommendationResource($mlceRecommendation),
            "MlceRecommendation updated successfully!"
        );
    }

    public function complete(MlceRecommendation $mlceRecommendation) {
        $data = request()->validate([
            "is_implemented" => ["required", 'boolean'],
            "comment" => ["nullable", "string"],
        ]);

        if ($mlceRecommendation->status === MlceRecommendationStatus::COMPLETED->value) {
            return $this->respondError("Recommendation has already been completed!", statusCode: 400);
        }

        $mlceRecommendation->update([
            "status" => MlceRecommendationStatus::COMPLETED->value,
            "completed_at" => now()->format("Y-m-d H:i:s"),
            "is_implemented" => $data["is_implemented"],
            "comment" => $data["comment"],
        ]);
        $mlceRecommendation->mlceIndent->checkAndUpdateCompletedStatus();

        return $this->respondSuccess("Recommendation has been completed successfully!");
    }

    /**
     * Remove the specified mlceRecommendation from storage.
     */
    public function destroy(MlceRecommendation $mlceRecommendation): JsonResponse {
        $this->deleteFiles($mlceRecommendation);
        $mlceRecommendation->delete();

        return $this->respondSuccess("MlceRecommendation deleted successfully!");
    }
}
