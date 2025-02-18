<?php

namespace App\Http\Resources;

use App\Models\MlceIndentLocation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MlceIndentLocation */
class MlceIndentLocationResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'mlce_indent_id' => $this->mlce_indent_id,

            'location' => $this->location,
            'address' => $this->address,
            'spoc_name' => $this->spoc_name,
            'spoc_email' => $this->spoc_email,
            'spoc_mobile_no' => $this->spoc_mobile_no,
            'spoc_whatsapp_no' => $this->spoc_whatsapp_no,
            'google_map_link' => $this->google_map_link,
            'status' => $this->status,

            // relations
            'mlce_indent' => new MlceIndentResource($this->whenLoaded('mlceIndent')),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
