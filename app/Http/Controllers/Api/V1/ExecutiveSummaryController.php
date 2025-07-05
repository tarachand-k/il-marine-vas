<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExecutiveSummaryRequest;
use App\Http\Resources\ExecutiveSummaryResource;
use App\Models\ExecutiveSummary;
use Illuminate\Http\JsonResponse;

class ExecutiveSummaryController extends Controller
{
    public function index(): JsonResponse
    {
        $executiveSummaries = $this->paginateOrGet(ExecutiveSummary::latest());

        return $this->respondWithResourceCollection(
            ExecutiveSummaryResource::collection($executiveSummaries)
        );
    }

    /**
     * Store a newly created executiveSummary in storage.
     */
    public function store(ExecutiveSummaryRequest $request): JsonResponse
    {
        $executiveSummary = ExecutiveSummary::create($request->validated());

        return $this->respondCreated(
            new ExecutiveSummaryResource($executiveSummary),
            "Executive Summary created successfully!"
        );
    }

    /**
     * Display the specified executiveSummary.
     */
    public function show(ExecutiveSummary $executiveSummary): JsonResponse
    {
        return $this->respondWithResource(new ExecutiveSummaryResource($executiveSummary));
    }

    /**
     * Update the specified executiveSummary in storage.
     */
    public function update(ExecutiveSummaryRequest $request, ExecutiveSummary $executiveSummary): JsonResponse
    {
        $executiveSummary->update($request->validated());

        return $this->respondUpdated(
            new ExecutiveSummaryResource($executiveSummary),
            "Executive Summary updated successfully!"
        );
    }

    /**
     * Remove the specified executiveSummary from storage.
     */
    public function destroy(ExecutiveSummary $executiveSummary): JsonResponse
    {
        $executiveSummary->delete();

        return $this->respondSuccess("Executive Summary deleted successfully!");
    }
}
