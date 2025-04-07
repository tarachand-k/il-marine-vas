<?php

namespace App\Http\Resources;

use App\Models\Disclaimer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Disclaimer */
class DisclaimerResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            
            'title' => $this->title,
            'content' => $this->content,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
