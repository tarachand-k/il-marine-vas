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
        'sub_location',
        'brief',
        'type',
        'current_observation',
        "photo_1_desc",
        "photo_2_desc",
        "photo_3_desc",
        "photo_4_desc",
    ];

    protected static function boot(): void {
        parent::boot();

        // Before creating a mlce ref, set the ref_no
        static::creating(function (AssignmentObservation $assignmentObservation) {
            $location = $assignmentObservation->mlceAssignment->mlceIndentLocation->location;
            $assignmentObservation->ref_no = self::generateRefNo($location, $assignmentObservation->mlce_assignment_id);
        });
    }


    public static function generateRefNo(string $location, string $mlceAssignmentId): string {
        $formattedLocation = str_replace(" ", "-", strtoupper($location));
        $count = self::where('mlce_assignment_id', $mlceAssignmentId)->count() + 1;
        return $formattedLocation.'-OBS-'.$count;
    }

    public function mlceAssignment(): BelongsTo {
        return $this->belongsTo(MlceAssignment::class);
    }
}
