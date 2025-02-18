<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NavigationReportManualRequest;
use App\Http\Resources\NavigationReportManualResource;
use App\Models\NavigationReportManual;
use Illuminate\Http\JsonResponse;

class NavigationReportManualController extends Controller
{
    public function index(): JsonResponse {
        $navigationReportManuals = $this->paginateOrGet(NavigationReportManual::latest());

        return $this->respondWithResourceCollection(
            NavigationReportManualResource::collection($navigationReportManuals)
        );
    }

    /**
     * Store a newly created navigationReportManual in storage.
     */
    public function store(NavigationReportManualRequest $request): JsonResponse {
        $navigationReportManual = NavigationReportManual::create($request->validated());

        return $this->respondCreated(
            new NavigationReportManualResource($navigationReportManual),
            "NavigationReportManual created successfully!"
        );
    }

    /**
     * Display the specified navigationReportManual.
     */
    public function show(NavigationReportManual $navigationReportManual): JsonResponse {
        return $this->respondWithResource(new NavigationReportManualResource($navigationReportManual));
    }

    /**
     * Update the specified navigationReportManual in storage.
     */
    public function update(
        NavigationReportManualRequest $request,
        NavigationReportManual $navigationReportManual
    ): JsonResponse {
        $navigationReportManual->update($request->validated());

        return $this->respondUpdated(
            new NavigationReportManualResource($navigationReportManual),
            "NavigationReportManual updated successfully!"
        );
    }

    /**
     * Remove the specified navigationReportManual from storage.
     */
    public function destroy(NavigationReportManual $navigationReportManual): JsonResponse {
        $navigationReportManual->delete();

        return $this->respondSuccess("NavigationReportManual deleted successfully!");
    }
}
