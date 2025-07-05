<?php

namespace App\Http\Resources;

use App\Models\MlceSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MlceSchedule */
class MlceScheduleResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'rm_id' => $this->rm_id,
            'customer_id' => $this->customer_id,

            'date' => $this->date,

            // relations
            'user' => new UserResource($this->whenLoaded('user')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
