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
            'policy_no' => $this->policy_no,
            'policy_type' => $this->policy_type,
            'policy_start_date' => $this->policy_start_date,
            'policy_end_date' => $this->policy_end_date,
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
