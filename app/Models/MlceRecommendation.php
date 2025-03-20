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
        'brief',
        'closure_priority',
        'capital_involvement',
        'current_observation',
        'hazard',
        'recommendations',
        'client_response',
        'status',
        'timeline',
        "photo_1_desc",
        "photo_2_desc",
        "photo_3_desc",
        "photo_4_desc",
    ];

    protected static function boot(): void {
        parent::boot();

        // Before creating a mlce ref, set the ref_no
        static::creating(function (MlceRecommendation $mlceRecommendation) {
            $mlceRecommendation->ref_no = self::generateRefNo($mlceRecommendation->mlce_assignment_id);
        });
    }


    public static function generateRefNo(string $mlceAssignmentId): string {
        $count = self::where('mlce_assignment_id', $mlceAssignmentId)->count() + 1;
        return 'REC-'.$count;
    }

    public function mlceAssignment(): BelongsTo {
        return $this->belongsTo(MlceAssignment::class);
    }
}
