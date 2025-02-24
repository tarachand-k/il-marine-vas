<?php

namespace App\Http\Resources;

use App\Models\VideoUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin VideoUser */
class VideoUserResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'video_id' => $this->video_id,
            'user_id' => $this->user_id,

            // 'video' => new VideoResource($this->whenLoaded('video')),
            // 'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
