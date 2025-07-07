<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExecutiveSummaryPhotoRequest;
use App\Http\Resources\ExecutiveSummaryPhotoResource;
use App\Models\ExecutiveSummaryPhoto;
use App\Models\MlceIndent;
use Illuminate\Http\JsonResponse;

class ExecutiveSummaryPhotoController extends Controller
{
    protected ?string $resourceName = "mlce-indents/executive-summaries";

    protected array $fileFieldNames = [
        "photo",
    ];

    protected array $fileFolderPaths = [
        "photos",
    ];

    /**
     * Display a listing of photos for a specific executive summary.
     */
    public function index(MlceIndent $mlceIndent): JsonResponse
    {
        $photos = $mlceIndent->executiveSummaryPhotos()->get();

        return $this->respondWithResourceCollection(
            ExecutiveSummaryPhotoResource::collection($photos)
        );
    }

    /**
     * Store a newly created photo in storage.
     */
    public function store(ExecutiveSummaryPhotoRequest $request, MlceIndent $mlceIndent): JsonResponse
    {
        // Check if adding another photo would exceed the limit
        $currentCount = $mlceIndent->executiveSummaryPhotos()->count();
        if ($currentCount >= 20) {
            return $this->respondError("Maximum 20 photos allowed per executive summary.", statusCode: 422);
        }

        $photo = $mlceIndent->executiveSummaryPhotos()->make($request->validated());
        $this->storeFiles($request, $photo);
        $photo->save();

        return $this->respondCreated(
            new ExecutiveSummaryPhotoResource($photo),
            "Photo added successfully!"
        );
    }

    /**
     * Display the specified photo.
     */
    public function show(int $mlceIndent, ExecutiveSummaryPhoto $photo): JsonResponse
    {
        return $this->respondWithResource(new ExecutiveSummaryPhotoResource($photo));
    }

    /**
     * Update the specified photo in storage.
     */
    public function update(ExecutiveSummaryPhotoRequest $request, int $mlceIndent, ExecutiveSummaryPhoto $photo): JsonResponse
    {
        $photo->fill($request->validated());
        $this->updateFiles($request, $photo);
        $photo->save();

        return $this->respondUpdated(
            new ExecutiveSummaryPhotoResource($photo),
            "Photo updated successfully!"
        );
    }

    /**
     * Remove the specified photo from storage.
     */
    public function destroy(int $mlceIndent, ExecutiveSummaryPhoto $photo): JsonResponse
    {
        $this->deleteFiles($photo);
        $photo->delete();

        return $this->respondSuccess("Photo deleted successfully!");
    }
}
