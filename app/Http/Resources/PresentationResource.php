<?php

namespace App\Http\Resources;

use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Presentation */
class PresentationResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'uploaded_by_id' => $this->uploaded_by_id,

            'title' => $this->title,
            'description' => $this->description,
            'presentation' => $this->presentation,
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
