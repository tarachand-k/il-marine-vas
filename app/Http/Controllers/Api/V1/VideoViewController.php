<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoViewRequest;
use App\Http\Resources\VideoViewResource;
use App\Models\Video;
use App\Models\VideoView;

class VideoViewController extends Controller
{
    public function index(Video $video) {
        $views = $video->views()
            ->with("user")
            ->orderBy("viewed_at", 'desc')
            ->get();

        return $this->respondWithResourceCollection(
            VideoViewResource::collection($views));
    }

    public function store(Video $video, VideoViewRequest $request) {
        $video->views()->create([
            "user_id" => auth()->id(),
            "viewed_at" => now()->format("Y-m-d H:i:s"),
        ]);
        $video->increment("view_count");

        return new VideoViewResource(VideoView::create($request->validated()));
    }
}
