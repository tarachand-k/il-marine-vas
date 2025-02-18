<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MlceRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'mlce_assignment_id',

        'ref_no',
        'location',
        'sub_location',
        'brief',
        'closure_priority',
        'is_capital_required',
        'current_observation',
        'hazard',
        'recommendations',
        'client_response',
        'status',
        'timeline',
    ];

    public function mlceAssignment(): BelongsTo {
        return $this->belongsTo(MlceAssignment::class);
    }
}
