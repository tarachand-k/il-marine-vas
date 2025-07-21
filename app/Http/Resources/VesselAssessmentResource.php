<?php

namespace App\Http\Resources;

use App\Models\VesselAssessment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin VesselAssessment */
class VesselAssessmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            // Foreign keys
            'customer_id' => $this->customer_id,
            'created_by_id' => $this->created_by_id,
            'assigned_to_id' => $this->assigned_to_id,
            'approved_by_id' => $this->approved_by_id,

            // Enums
            'status' => $this->status,

            // Basic Vessel Details
            'vessel_name' => $this->vessel_name,
            'imo_no' => $this->imo_no,
            'cargo_commodity_description' => $this->cargo_commodity_description,
            'load_type' => $this->load_type,

            // Assessment Parameters
            'age_of_vessel' => $this->age_of_vessel,
            'vessel_type_detail' => $this->vessel_type_detail,
            'flag' => $this->flag,
            'is_iacs_class' => $this->is_iacs_class,
            'psc_detention_last_6_months' => $this->psc_detention_last_6_months,
            'machinery_deficiencies_remarks' => $this->machinery_deficiencies_remarks,
            'is_sanction_compliant' => $this->is_sanction_compliant,
            'has_active_insurance' => $this->has_active_insurance,
            'vessel_approved_for_cargo' => $this->vessel_approved_for_cargo,
            'other_remarks' => $this->other_remarks,
            'final_remarks' => $this->final_remarks,
            'description' => $this->description,

            // Reference
            'ref_no' => $this->ref_no,

            // Workflow Timestamps
            'assigned_at' => $this->assigned_at,
            'submitted_at' => $this->submitted_at,
            'approved_at' => $this->approved_at,
            'completed_at' => $this->completed_at,

            // Relations
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'created_by' => new UserResource($this->whenLoaded('createdBy')),
            'assigned_to' => new UserResource($this->whenLoaded('assignedTo')),
            'assigned_by' => new UserResource($this->whenLoaded('assignedBy')),
            'approved_by' => new UserResource($this->whenLoaded('approvedBy')),

            // Timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
