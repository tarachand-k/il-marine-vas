<?php

namespace App\Http\Resources;

use App\Models\ExecutiveSummaryPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ExecutiveSummaryPhoto */
class ExecutiveSummaryPhotoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'photo' => $this->photo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'mlce_indent_id' => $this->mlce_indent_id,

            'mlceIndent' => new ExecutiveSummaryResource($this->whenLoaded('mlceIndent')),
        ];
    }
}
