<?php

namespace App\Http\Resources;

use App\Models\SopView;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SopView */
class SopViewResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'viewed_at' => $this->viewed_at,

            'sop_id' => $this->sop_id,
            'user_id' => $this->user_id,

            // 'sop' => new SopResource($this->whenLoaded('sop')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
