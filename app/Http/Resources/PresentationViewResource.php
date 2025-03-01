<?php

namespace App\Http\Resources;

use App\Models\PresentationView;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PresentationView */
class PresentationViewResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'viewed_at' => $this->viewed_at,

            'presentation_id' => $this->presentation_id,
            'user_id' => $this->user_id,

            // 'presentation' => new PresentationResource($this->whenLoaded('presentation')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
