<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PresentationViewResource;
use App\Models\Presentation;

class PresentationViewController extends Controller
{
    public function index(Presentation $presentation) {
        $views = $this->paginateOrGet(
            $presentation->views()
                ->with("user:id,name,email,mobile_no,role")
                ->orderBy("viewed_at", 'desc'));

        return $this->respondSuccess(null, $views);
    }

    public function store(Presentation $presentation) {
        $view = $presentation->views()->create([
            "user_id" => request()->user()->id,
            "viewed_at" => now()->format("Y-m-d H:i:s"),
        ]);
        $presentation->increment("view_count");

        return $this->respondCreated(new PresentationViewResource($view), "Video view has been created");
    }

    public function getViewsByUser(Presentation $presentation, string $userId) {

        $views = $presentation->views()
            ->select("id", "viewed_at")
            ->where("user_id", $userId)
            ->latest("viewed_at")
            ->get();

        return $this->respondSuccess(null, $views);
    }

    public function stats(Presentation $presentation) {
        $views = $presentation->views()
            ->with("user:id,name,email,mobile_no,role")
            ->selectRaw("user_id, count(*) as view_count")
            ->groupBy("user_id")
            ->get();

        return $this->respondSuccess(null, $views);
    }
}
