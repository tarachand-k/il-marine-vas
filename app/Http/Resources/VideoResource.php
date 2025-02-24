<?php

namespace App\Http\Resources;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Video */
class VideoResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'uploaded_by_id' => $this->uploaded_by_id,

            'title' => $this->title,
            'description' => $this->description,
            'video' => $this->video,
            'view_count' => $this->view_count,

            // relations
            'uploaded_by' => new UserResource($this->whenLoaded('uploadedBy')),
            'allowed_users' => UserResource::collection($this->whenLoaded("allowedUsers")),
            'views' => VideoViewResource::collection($this->whenLoaded("views")),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
