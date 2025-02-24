<?php

namespace App\Http\Resources;

use App\Models\VideoView;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin VideoView */
class VideoViewResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'video_id' => $this->video_id,
            'user_id' => $this->user_id,

            'viewed_at' => $this->viewed_at,

            // 'video' => new VideoResource($this->whenLoaded('video')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
