<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MlceReportStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\MlceReportRequest;
use App\Http\Resources\MlceReportResource;
use App\Models\MlceReport;
use Illuminate\Http\JsonResponse;

class MlceReportController extends Controller
{
    protected array $relations = [
        "mlceIndent", "mlceAssignment", "customer", "views"
    ];

    public function index(): JsonResponse {
        $mlceReports = $this->paginateOrGet(
            MlceReport::with($this->getRelations())->filter()->latest());

        return $this->respondWithResourceCollection(
            MlceReportResource::collection($mlceReports)
        );
    }

    /**
     * Store a newly created mlceReport in storage.
     */
    public function store(MlceReportRequest $request): JsonResponse {
        $mlceReport = MlceReport::create($request->validated());

        return $this->respondCreated(
            new MlceReportResource($mlceReport),
            "MlceReport created successfully!"
        );
    }

    public function approveReport(MlceReport $mlceReport) {
        if ($mlceReport->status !== MlceReportStatus::SUBMITTED->value) {
            return $this->respondError("Report has already been approved!", null, 400);
        }

        $mlceReport->update([
            "status" => MlceReportStatus::APPROVED->value,
            "approved_at" => now()->format("Y-m-d H:i:s"),
        ]);

        return $this->respondSuccess("Report has been approved successfully!");
    }

    /**
     * Update the specified mlceReport in storage.
     */
    public function update(MlceReportRequest $request, MlceReport $mlceReport): JsonResponse {
        $mlceReport->update($request->validated());

        return $this->respondUpdated(
            new MlceReportResource($mlceReport),
            "MlceReport updated successfully!"
        );
    }

    public function publishReport(MlceReport $mlceReport) {
        if ($mlceReport->status === MlceReportStatus::PUBLISHED->value) {
            return $this->respondError("Report has already been published!", null, 400);
        }

        $mlceReport->update([
            "status" => MlceReportStatus::PUBLISHED->value,
            "published_at" => now()->format("Y-m-d H:i:s"),
        ]);

        return $this->respondSuccess("Report has been published successfully!");
    }

    /**
     * Display the specified mlceReport.
     */
    public function show(MlceReport $mlceReport): JsonResponse {
        // create report view and increment view count
        $mlceReport->views()->create(["user_id" => request()->user()->id]);
        $mlceReport->increment("view_count");

        $mlceReport->load($this->getRelations());

        return $this->respondWithResource(new MlceReportResource($mlceReport));
    }

    /**
     * Remove the specified mlceReport from storage.
     */
    public function destroy(MlceReport $mlceReport): JsonResponse {
        $mlceReport->delete();

        return $this->respondSuccess("MlceReport deleted successfully!");
    }
}
