<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MlceScheduleRequest;
use App\Http\Resources\MlceScheduleResource;
use App\Models\MlceSchedule;
use Illuminate\Http\JsonResponse;

class MlceScheduleController extends Controller
{
    protected array $relations = ["user", "customer"];

    public function index(): JsonResponse {
        $mlceSchedules = $this->paginateOrGet(
            MlceSchedule::with($this->getRelations())->latest("id")
        );

        return $this->respondWithResourceCollection(
            MlceScheduleResource::collection($mlceSchedules)
        );
    }

    /**
     * Store a newly created mlceSchedule in storage.
     */
    public function store(MlceScheduleRequest $request): JsonResponse {
        $mlceSchedule = MlceSchedule::create($request->validated());

        return $this->respondCreated(
            new MlceScheduleResource($mlceSchedule),
            "MlceSchedule created successfully!"
        );
    }

    /**
     * Display the specified mlceSchedule.
     */
    public function show(MlceSchedule $mlceSchedule): JsonResponse {
        $mlceSchedule->load($this->getRelations());

        return $this->respondWithResource(
            new MlceScheduleResource($mlceSchedule));
    }

    /**
     * Update the specified mlceSchedule in storage.
     */
    public function update(MlceScheduleRequest $request, MlceSchedule $mlceSchedule): JsonResponse {
        $mlceSchedule->update($request->validated());

        return $this->respondUpdated(
            new MlceScheduleResource($mlceSchedule),
            "MlceSchedule updated successfully!"
        );
    }

    /**
     * Remove the specified mlceSchedule from storage.
     */
    public function destroy(MlceSchedule $mlceSchedule): JsonResponse {
        $mlceSchedule->delete();

        return $this->respondSuccess("MlceSchedule deleted successfully!");
    }
}
