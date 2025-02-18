<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutUsRequest;
use App\Http\Resources\AboutUsResource;
use App\Models\AboutUs;
use Illuminate\Http\JsonResponse;

class AboutUsController extends Controller
{
    public function index(): JsonResponse {
        $aboutUs = $this->paginateOrGet(AboutUs::latest());

        return $this->respondWithResourceCollection(
            AboutUsResource::collection($aboutUs)
        );
    }

    /**
     * Store a newly created aboutUs in storage.
     */
    public function store(AboutUsRequest $request): JsonResponse {
        $aboutUs = AboutUs::create($request->validated());

        return $this->respondCreated(
            new AboutUsResource($aboutUs),
            "AboutUs created successfully!"
        );
    }

    /**
     * Display the specified aboutUs.
     */
    public function show(AboutUs $aboutUs): JsonResponse {
        return $this->respondWithResource(new AboutUsResource($aboutUs));
    }

    /**
     * Update the specified aboutUs in storage.
     */
    public function update(AboutUsRequest $request, AboutUs $aboutUs): JsonResponse {
        $aboutUs->update($request->validated());

        return $this->respondUpdated(
            new AboutUsResource($aboutUs),
            "AboutUs updated successfully!"
        );
    }

    /**
     * Remove the specified aboutUs from storage.
     */
    public function destroy(AboutUs $aboutUs): JsonResponse {
        $aboutUs->delete();

        return $this->respondSuccess("AboutUs deleted successfully!");
    }
}
