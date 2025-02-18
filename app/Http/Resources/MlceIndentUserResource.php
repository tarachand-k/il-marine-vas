<?php

namespace App\Http\Resources;

use App\Models\MlceIndentUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MlceIndentUser */
class MlceIndentUserResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'mlce_indent_id' => $this->mlce_indent_id,
            'user_id' => $this->user_id,

            'type' => $this->type,

            // relations
            // 'mlce_indent' => new MlceIndentResource($this->whenLoaded('mlceIndent')),
            // 'user' => new UserResource($this->whenLoaded('user')),

            // timestamps
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
