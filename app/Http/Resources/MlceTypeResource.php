<?php

namespace App\Http\Resources;

use App\Models\MlceType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MlceType */
class MlceTypeResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
