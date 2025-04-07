<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SopViewResource;
use App\Models\Sop;

class SopViewController extends Controller
{
    public function index(Sop $sop) {
        $views = $this->paginateOrGet(
            $sop->views()
                ->with("user:id,name,email,mobile_no,role")
                ->orderBy("viewed_at", 'desc'));

        return $this->respondSuccess(data: $views);
    }

    public function store(Sop $sop) {
        $view = $sop->views()->create([
            "user_id" => request()->user()->id,
            "viewed_at" => now()->format("Y-m-d H:i:s"),
        ]);
        $sop->increment("view_count");

        return $this->respondCreated(new SopViewResource($view), "Sop view has been created");
    }

    public function getViewsByUser(Sop $sop, string $userId) {

        $views = $sop->views()
            ->select("id", "viewed_at")
            ->where("user_id", $userId)
            ->latest("viewed_at")
            ->get();

        return $this->respondSuccess(null, $views);
    }

    public function stats(Sop $sop) {
        $views = $sop->views()
            ->with("user:id,name,email,mobile_no,role")
            ->selectRaw("user_id, count(*) as view_count")
            ->groupBy("user_id")
            ->get();

        return $this->respondSuccess(null, $views);
    }
}
