<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresentationRequest;
use App\Http\Resources\PresentationResource;
use App\Models\Presentation;
use Illuminate\Http\JsonResponse;

class PresentationController extends Controller
{
    protected array $relations = [
        "uploadedBy", "allowedUsers",
    ];


    protected array $fileFieldNames = [
        "presentation",
    ];

    protected array $fileFolderPaths = [
        "presentations",
    ];

    /**
     * Display a listing of the presentations.
     */
    public function index(): JsonResponse {
        $presentations = $this->paginateOrGet(
            Presentation::with($this->getRelations())->latest());

        return $this->respondWithResourceCollection(
            PresentationResource::collection($presentations)
        );
    }

    /**
     * Store a newly created presentation in storage.
     */
    public function store(PresentationRequest $request): JsonResponse {
        $presentation = new Presentation($request->validated());
        $this->storeFiles($request, $presentation);
        $presentation->save();

        if ($request->has("allowed_users")) {
            $presentation->allowedUsers()->attach($request->validated("allowed_users"));
        }

        return $this->respondCreated(
            new PresentationResource($presentation),
            "Presentation created successfully!"
        );
    }

    /**
     * Display the specified presentation.
     */
    public function show(Presentation $presentation): JsonResponse {
        $presentation->loadMissing($this->getRelations());

        return $this->respondWithResource(new PresentationResource($presentation));
    }

    /**
     * Update the specified presentation in storage.
     */
    public function update(PresentationRequest $request, Presentation $presentation): JsonResponse {
        $presentation->fill($request->validated());
        $this->updateFiles($request, $presentation);
        $presentation->save();

        if ($request->has("allowed_users")) {
            $presentation->allowedUsers()->sync($request->validated("allowed_users"));
        }

        return $this->respondUpdated(
            new PresentationResource($presentation),
            "Presentation updated successfully!"
        );
    }

    /**
     * Remove the specified presentation from storage.
     */
    public function destroy(Presentation $presentation): JsonResponse {
        $this->deleteFiles($presentation);
        $presentation->delete();

        return $this->respondSuccess("Presentation deleted successfully!");
    }
}
