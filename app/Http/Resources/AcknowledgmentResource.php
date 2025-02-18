<?php

namespace App\Http\Resources;

use App\Models\Acknowledgment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Acknowledgment */
class AcknowledgmentResource extends JsonResource
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
