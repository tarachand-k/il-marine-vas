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
        'indent_code'
    ];

    protected $fillable = [
        'created_by_id',
        'customer_id',
        'mlce_type_id',

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
}
