<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use App\Enums\VesselAssessmentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VesselAssessment extends Model
{
    use HasFactory, Filterable;

    public $filterFields = [
        'customer_id',
        'created_by_id',
        'assigned_to_id',
        'assigned_by_id',
        'approved_by_id',
        'vessel_type',
        'status',
        'vessel_name',
        'imo_no',
        'load_type',
        'ref_no',
    ];

    protected $fillable = [
        'customer_id',
        'created_by_id',
        'assigned_to_id',
        'assigned_by_id',
        'approved_by_id',
        'vessel_type',
        'status',
        'vessel_name',
        'imo_no',
        'cargo_commodity_description',
        'load_type',
        'age_of_vessel',
        'vessel_type_detail',
        'flag',
        'is_iacs_class',
        'psc_detention_last_6_months',
        'machinery_deficiencies_remarks',
        'is_sanction_compliant',
        'has_active_insurance',
        'vessel_approved_for_cargo',
        'other_remarks',
        'final_remarks',
        'description',
        'ref_no',
        'assigned_at',
        'submitted_at',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'status' => VesselAssessmentStatus::class,
        'is_iacs_class' => 'boolean',
        'is_sanction_compliant' => 'boolean',
        'assigned_at' => 'datetime',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ref_no)) {
                $model->ref_no = self::generateRefNo();
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function scopeForCustomer(Builder $query, int $customerId): Builder
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeAssignedTo(Builder $query, int $userId): Builder
    {
        return $query->where('assigned_to_id', $userId);
    }

    public function scopeByStatus(Builder $query, VesselAssessmentStatus $status): Builder
    {
        return $query->where('status', $status->value);
    }

    public static function generateRefNo(): string
    {
        $currentYear = now()->year;
        $currentDate = now()->format('md');

        $lastAssessment = static::where('ref_no', 'like', "VESSEL-ASSESS-FY{$currentYear}-{$currentDate}-%")
            ->orderBy('ref_no', 'desc')
            ->first();

        if ($lastAssessment) {
            $lastNumber = (int)substr($lastAssessment->ref_no, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return "VESSEL-ASSESS-FY{$currentYear}-{$currentDate}-" . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function canBeAssigned(): bool
    {
        return $this->status === VesselAssessmentStatus::INITIALIZED;
    }

    public function canBeSubmitted(): bool
    {
        return $this->status === VesselAssessmentStatus::ASSIGNED || $this->status === VesselAssessmentStatus::IN_PROGRESS;
    }

    public function canBeApproved(): bool
    {
        return $this->status === VesselAssessmentStatus::SUBMITTED;
    }

    public function canBeCompleted(): bool
    {
        return $this->status === VesselAssessmentStatus::INITIALIZED ||
            $this->status === VesselAssessmentStatus::ASSIGNED;
    }

    public function markAsAssigned(int $assignedToId, int $assignedById): void
    {
        $this->update([
            'assigned_to_id' => $assignedToId,
            'assigned_by_id' => $assignedById,
            'status' => VesselAssessmentStatus::ASSIGNED,
            'assigned_at' => now(),
        ]);
    }

    public function markAsInProgress(): void
    {
        $this->update([
            'status' => VesselAssessmentStatus::IN_PROGRESS,
        ]);
    }

    public function markAsSubmitted(): void
    {
        $this->update([
            'status' => VesselAssessmentStatus::SUBMITTED,
            'submitted_at' => now(),
        ]);
    }

    public function markAsApproved(int $approvedById): void
    {
        $this->update([
            'approved_by_id' => $approvedById,
            'status' => VesselAssessmentStatus::COMPLETED,
            'approved_at' => now(),
            'completed_at' => now(),
        ]);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => VesselAssessmentStatus::COMPLETED,
            'completed_at' => now(),
        ]);
    }
}
