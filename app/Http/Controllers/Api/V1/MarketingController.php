<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarketingRequest;
use App\Http\Resources\MarketingResource;
use App\Models\Marketing;
use Illuminate\Http\JsonResponse;

class MarketingController extends Controller
{
    public function index(): JsonResponse {
        $marketings = Marketing::all();

        return $this->respondWithResourceCollection(
            MarketingResource::collection($marketings)
        );
    }

    /**
     * Store a newly created marketing in storage.
     */
    public function store(MarketingRequest $request): JsonResponse {
        $marketing = Marketing::create($request->validated());

        return $this->respondCreated(
            new MarketingResource($marketing),
            "Marketing created successfully!"
        );
    }

    /**
     * Display the specified marketing.
     */
    public function show(Marketing $marketing): JsonResponse {
        return $this->respondWithResource(new MarketingResource($marketing));
    }

    /**
     * Update the specified marketing in storage.
     */
    public function update(MarketingRequest $request, Marketing $marketing): JsonResponse {
        $marketing->update($request->validated());

        return $this->respondUpdated(
            new MarketingResource($marketing),
            "Marketing updated successfully!"
        );
    }

    /**
     * Remove the specified marketing from storage.
     */
    public function destroy(Marketing $marketing): JsonResponse {
        $marketing->delete();

        return $this->respondSuccess("Marketing deleted successfully!");
    }
}
