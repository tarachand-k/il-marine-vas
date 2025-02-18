<?php

namespace App\Http\Resources;

use App\Models\WhyMlce;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin WhyMlce */
class WhyMlceResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
