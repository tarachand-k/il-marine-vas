<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportViewRequest;
use App\Http\Resources\ReportViewResource;
use App\Models\MlceReport;

class ReportViewController extends Controller
{
    public function index(MlceReport $mlceReport) {
        $reportViews = $this->paginateOrGet(
            $mlceReport->views()->with("user")->latest("viewed_at"));

        return $this->respondWithResourceCollection(
            ReportViewResource::collection($reportViews)
        );
    }

    public function store(ReportViewRequest $request, MlceReport $mlceReport) {
        $reportView = $mlceReport->views()->create($request->validated());

        return $this->respondCreated(
            new ReportViewResource($reportView),
            "Report view created successfully!"
        );
    }

}
