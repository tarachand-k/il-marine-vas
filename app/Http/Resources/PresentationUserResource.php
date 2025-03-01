<?php

namespace App\Http\Resources;

use App\Models\PresentationUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PresentationUser */
class PresentationUserResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'presentation_id' => $this->presentation_id,
            'user_id' => $this->user_id,

            // 'presentation' => new PresentationResource($this->whenLoaded('presentation')),
            // 'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
