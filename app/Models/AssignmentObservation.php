<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentObservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'mlce_assignment_id',

        'ref_no',
        'location',
        'sub_location',
        'brief',
        'type',
        'current_observation',
        "photo_1_desc",
        "photo_2_desc",
        "photo_3_desc",
        "photo_4_desc",
    ];

    public function mlceAssignment(): BelongsTo {
        return $this->belongsTo(MlceAssignment::class);
    }
}
