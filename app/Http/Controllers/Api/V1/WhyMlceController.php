<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhyMlceRequest;
use App\Http\Resources\WhyMlceResource;
use App\Models\WhyMlce;
use Illuminate\Http\JsonResponse;

class WhyMlceController extends Controller
{
    public function index(): JsonResponse {
        $whyMlce = $this->paginateOrGet(WhyMlce::latest());

        return $this->respondWithResourceCollection(
            WhyMlceResource::collection($whyMlce)
        );
    }

    /**
     * Store a newly created whyMlce in storage.
     */
    public function store(WhyMlceRequest $request): JsonResponse {
        $whyMlce = WhyMlce::create($request->validated());

        return $this->respondCreated(
            new WhyMlceResource($whyMlce),
            "WhyMlce created successfully!"
        );
    }

    /**
     * Display the specified whyMlce.
     */
    public function show(WhyMlce $whyMlce): JsonResponse {
        return $this->respondWithResource(new WhyMlceResource($whyMlce));
    }

    /**
     * Update the specified whyMlce in storage.
     */
    public function update(WhyMlceRequest $request, WhyMlce $whyMlce): JsonResponse {
        $whyMlce->update($request->validated());

        return $this->respondUpdated(
            new WhyMlceResource($whyMlce),
            "WhyMlce updated successfully!"
        );
    }

    /**
     * Remove the specified whyMlce from storage.
     */
    public function destroy(WhyMlce $whyMlce): JsonResponse {
        $whyMlce->delete();

        return $this->respondSuccess("WhyMlce deleted successfully!");
    }
}
