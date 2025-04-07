<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MlceRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'mlce_indent_id',
        'mlce_assignment_id',

        'ref_no',
        'sub_location',
        'brief',
        'closure_priority',
        'capital_involvement',
        'current_observation',
        'hazard',
        'recommendations',
        'client_response',
        'status',
        'timeline',
        'completed_at',
        'is_implemented',
        'comment',
        "photo_1_desc",
        "photo_2_desc",
        "photo_3_desc",
        "photo_4_desc",
    ];

    protected static function boot(): void {
        parent::boot();

        // Before creating a mlce ref, set the ref_no
        static::creating(function (MlceRecommendation $mlceRecommendation) {
            $location = $mlceRecommendation->mlceAssignment->mlceIndentLocation->location;
            $mlceRecommendation->ref_no = self::generateRefNo($location, $mlceRecommendation->mlce_assignment_id);
        });
    }


    public static function generateRefNo(string $location, string $mlceAssignmentId): string {
        $formattedLocation = str_replace(" ", "-", strtoupper($location));
        $count = self::where('mlce_assignment_id', $mlceAssignmentId)->count() + 1;
        return $formattedLocation.'-REC-'.$count;
    }

    public function mlceAssignment(): BelongsTo {
        return $this->belongsTo(MlceAssignment::class);
    }

    public function mlceIndent(): BelongsTo {
        return $this->belongsTo(MlceIndent::class, "mlce_indent_id");
    }
}
