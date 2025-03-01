<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Customer */
class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'name' => $this->name,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'transit_coverage_from' => $this->transit_coverage_from,
            'transit_coverage_to' => $this->transit_coverage_to,
            'about' => $this->about,
            'coverage_terms' => $this->coverage_terms,
            'cargo_details' => $this->cargo_details,
            'transit_details' => $this->transit_details,

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
