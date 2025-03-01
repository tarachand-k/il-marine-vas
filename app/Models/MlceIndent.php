<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MlceIndent extends Model
{
    use HasFactory, Filterable;

    public $filterFields = [
        'created_by_id',
        'customer_id',
        'mlce_type_id',
        "insured_representative_id",
        "rm_id",
        "vertical_rm_id",
        "under_writer_id",

        'indent_code',
        'ref_no',
        'policy_no',
        'policy_type',
        'policy_start_date',
        'policy_end_date',
    ];

    protected $fillable = [
        'created_by_id',
        'customer_id',
        'mlce_type_id',
        "insured_representative_id",
        "rm_id",
        "vertical_rm_id",
        "under_writer_id",

        'ref_no',
        'policy_no',
        'policy_no',
        'policy_type',
        'policy_start_date',
        'policy_end_date',
        'hub',
        'gwp',
        'nic',
        'nep',
        'lr_percentage',
        'vertical_name',
        'insured_commodity',
        'industry',
        'job_scope',
        'why_mlce'
    ];

    protected static function boot(): void {
        parent::boot();

        // Before creating a mlce indent, set the indent_code
        static::creating(function ($mlceIndent) {
            $mlceIndent->indent_code = self::generateIndentCode();
        });
    }


    public static function generateIndentCode(): string {
        $count = self::whereYear('created_at', now()->year)->count() + 1;
        return 'MLCE-INDENT-FY'.now()->format('y').'-'.now()->format("dmy").'-'
            .str_pad($count, 6, '0', STR_PAD_LEFT);
    }

    public function createdBy(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function mlceType(): BelongsTo {
        return $this->belongsTo(MlceType::class);
    }

    public function insuredRepresentative(): BelongsTo {
        return $this->belongsTo(User::class, "insured_representative_id");
    }

    public function rm(): BelongsTo {
        return $this->belongsTo(User::class, "rm_id");
    }

    public function verticalRm(): BelongsTo {
        return $this->belongsTo(User::class, "vertical_rm_id");
    }

    public function underWriter(): BelongsTo {
        return $this->belongsTo(User::class, "under_writer_id");
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class)
            ->using(MlceIndentUser::class)
            ->withPivot(['id', 'type']);
    }

    public function assignments(): HasMany {
        return $this->hasMany(MlceAssignment::class, 'mlce_indent_id')
            ->with(["assignmentObservations", "assigneeLocationTracks", "mlceRecommendations"]);
    }

    public function report(): HasOne {
        return $this->hasOne(MlceReport::class, 'mlce_indent_id');
    }

    public function locations(): HasMany {
        return $this->hasMany(MlceIndentLocation::class, 'mlce_indent_id');
    }

    protected function casts(): array {
        return [
            'job_scope' => 'array',
        ];
    }
}
