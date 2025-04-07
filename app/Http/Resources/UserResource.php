<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'created_by_id' => $this->created_by_id,
            'customer_id' => $this->customer_id,

            'name' => $this->name,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'email_verified_at' => $this->email_verified_at,
            'role' => $this->role,
            'about' => $this->about,
            'status' => $this->status,
            'last_login_at' => $this->last_login_at,

            // file uploads
            'photo' => $this->photo,

            // relations
            "created_by" => new UserResource($this->whenLoaded("createdBy")),
            "customer" => new CustomerResource($this->whenLoaded("customer")),
            "mlce_indents_count" => $this->whenCounted("mlceIndents", $this->mlce_indents_count),
            "sops_count" => $this->whenCounted("sops", $this->sops_count),
            "videos_count" => $this->whenCounted("videos", $this->videos_count),
            "presentations_count" => $this->whenCounted("presentations", $this->presentations_count),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
