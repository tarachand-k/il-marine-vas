<?php

namespace App\Http\Resources;

use App\Models\Sop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Sop */
class SopResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'customer_id' => $this->customer_id,

            'pdf' => $this->pdf,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,

            'customer' => new CustomerResource($this->whenLoaded('customer')),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
