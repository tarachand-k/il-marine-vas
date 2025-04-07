<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MlceAssignment extends Model
{
    use HasFactory, Filterable;

    public $filterFields = [
        'mlce_indent_id',
        'mlce_indent_location_id',
        'inspector_id',
        'supervisor_id',

        'status',
        'completed_at',
    ];

    protected $fillable = [
        'mlce_indent_id',
        'mlce_indent_location_id',
        'inspector_id',
        'supervisor_id',

        'status',
        'completed_at',
        'observation_description',
    ];

    public function mlceIndent(): BelongsTo {
        return $this->belongsTo(MlceIndent::class);
    }

    public function mlceIndentLocation(): BelongsTo {
        return $this->belongsTo(MlceIndentLocation::class);
    }

    public function inspector(): BelongsTo {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function supervisor(): BelongsTo {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function assigneeLocationTracks(): HasMany {
        return $this->hasMany(AssigneeLocationTrack::class, 'mlce_assignment_id');
    }

    public function assignmentObservations(): HasMany {
        return $this->hasMany(AssignmentObservation::class, "mlce_assignment_id");
    }

    public function mlceRecommendations(): HasMany {
        return $this->hasMany(MlceRecommendation::class, 'mlce_assignment_id');
    }

    public function assignmentPhotos(): HasMany {
        return $this->hasMany(AssignmentPhoto::class, 'mlce_assignment_id');
    }

    protected function casts(): array {
        return [
            'observation_description' => 'array'
        ];
    }
}
