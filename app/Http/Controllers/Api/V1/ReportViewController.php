<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportViewRequest;
use App\Http\Resources\ReportViewResource;
use App\Models\MlceReport;
use Illuminate\Http\JsonResponse;

class ReportViewController extends Controller
{
    public function index(MlceReport $mlceReport): JsonResponse {
        $reportViews = $this->paginateOrGet(
            $mlceReport->views()->with("user")->latest("viewed_at"));

        return $this->respondWithResourceCollection(
            ReportViewResource::collection($reportViews)
        );
    }

    public function store(ReportViewRequest $request, MlceReport $mlceReport): JsonResponse {
        $reportView = $mlceReport->views()->create([
            "user_id" => $request->validated("user_id"),
            "page_name" => $request->validated("page_name"),
            "ip_address" => $request->ip(),
            "device_info" => $request->userAgent(),
        ]);

        if ($request->isNotFilled("page_name")) {
            $mlceReport->increment("view_count");
        }

        return $this->respondCreated(
            new ReportViewResource($reportView),
            "Report view created successfully!"
        );
    }

    public function reportWiseViews(MlceReport $mlceReport) {
        request()->validate(["user_id" => "required", "exists:users,id"]);

        $views = $mlceReport->views()
            ->whereNot("page_name")
            ->where("user_id", request()->query("user_id"))
            ->get();

        return $this->respondWithResourceCollection(
            ReportViewResource::collection($views));
    }

    public function pageWiseViews(MlceReport $mlceReport) {
        request()->validate(["user_id" => "required", "exists:users,id"]);

        $views = $mlceReport->views()
            ->whereNotNull("page_name")
            ->where("user_id", request()->query("user_id"))
            ->get();

        return $this->respondWithResourceCollection(
            ReportViewResource::collection($views));
    }

    public function stats(MlceReport $mlceReport) {
        $totalReportViews = $mlceReport->views()->whereNull("page_name")->count();

        $pageViews = $mlceReport->views()
            ->whereNotNull("page_name")
            ->selectRaw("page_name, count(page_name) as view_count")
            ->groupBy("page_name")
            ->get();

        $uniqueReportViewers = $mlceReport->views()
            ->with("user:id,name,email,role")
            ->whereNull("page_name")
            ->selectRaw("user_id, count(user_id) as view_count")
            ->groupBy("user_id")
            ->get();

        $uniquePageViewers = $mlceReport->views()
            ->with("user:id,name,email,role")
            ->whereNotNull("page_name")
            ->selectRaw("user_id, page_name, count(user_id) as view_count")
            ->groupBy("user_id", "page_name")
            ->get();

        return $this->respondSuccess(null, [
            "total_report_views" => $totalReportViews,
            "page_views" => $pageViews,
            "report_wise_viewers" => $uniqueReportViewers,
            "page_wise_viewers" => $uniquePageViewers,
        ]);
    }
}
