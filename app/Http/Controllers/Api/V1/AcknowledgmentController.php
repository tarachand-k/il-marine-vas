<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcknowledgmentRequest;
use App\Http\Resources\AcknowledgmentResource;
use App\Models\Acknowledgment;
use Illuminate\Http\JsonResponse;

class AcknowledgmentController extends Controller
{
    public function index(): JsonResponse {
        $acknowledgments = $this->paginateOrGet(Acknowledgment::latest());

        return $this->respondWithResourceCollection(
            AcknowledgmentResource::collection($acknowledgments)
        );
    }

    /**
     * Store a newly created acknowledgment in storage.
     */
    public function store(AcknowledgmentRequest $request): JsonResponse {
        $acknowledgment = Acknowledgment::create($request->validated());

        return $this->respondCreated(
            new AcknowledgmentResource($acknowledgment),
            "Acknowledgment created successfully!"
        );
    }

    /**
     * Display the specified acknowledgment.
     */
    public function show(Acknowledgment $acknowledgment): JsonResponse {
        return $this->respondWithResource(new AcknowledgmentResource($acknowledgment));
    }

    /**
     * Update the specified acknowledgment in storage.
     */
    public function update(AcknowledgmentRequest $request, Acknowledgment $acknowledgment): JsonResponse {
        $acknowledgment->update($request->validated());

        return $this->respondUpdated(
            new AcknowledgmentResource($acknowledgment),
            "Acknowledgment updated successfully!"
        );
    }

    /**
     * Remove the specified acknowledgment from storage.
     */
    public function destroy(Acknowledgment $acknowledgment): JsonResponse {
        $acknowledgment->delete();

        return $this->respondSuccess("Acknowledgment deleted successfully!");
    }
}
