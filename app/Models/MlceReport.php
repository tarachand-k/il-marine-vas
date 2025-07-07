<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MlceReport extends Model
{
    use HasFactory, Filterable;

    public $filterFields = [
        'mlce_indent_id',
        'customer_id',
        'submitted_by_id',
        'approved_by_id',

        'report_code',
        'status',
        'view_count',
        'approved_at',
        'published_at',
    ];

    protected $fillable = [
        'mlce_indent_id',
        'customer_id',
        'submitted_by_id',
        'approved_by_id',

        'report_code',
        'acknowledgment',
        'about_us',
        'marine_vas',
        'why_mlce',
        'navigation_report_manual',
        'findings',
        'observation_closure_summery',
        'disclaimer',
        'mlce_outcome',
        'executive_summary',
        'status',
        'view_count',
        'submitted_at',
        'approved_at',
        'published_at',
    ];

    protected static function boot(): void
    {
        parent::boot();

        // Before creating a mlce report, set the report_code
        static::creating(function ($mlceReport) {
            $mlceReport->report_code = self::generateReportCode();
        });
    }


    public static function generateReportCode(): string
    {
        $count = self::whereYear('created_at', now()->year)->count() + 1;
        return 'MLCE-REPORT-FY' . now()->format('y') . '-' . now()->format("dmy") . '-' . $count;
    }

    public function mlceIndent(): BelongsTo
    {
        return $this->belongsTo(MlceIndent::class);
    }

    public function mlceAssignment(): BelongsTo
    {
        return $this->belongsTo(MlceAssignment::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(ReportView::class, 'mlce_report_id');
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, "submitted_by_id");
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, "approved_by_id");
    }

    protected function casts(): array
    {
        return [
            'acknowledgment' => 'array',
            'about_us' => 'array',
            'marine_vas' => 'array',
            'why_mlce' => 'array',
            'navigation_report_manual' => 'array',
            'findings' => 'array',
            'observation_closure_summery' => 'array',
            'disclaimer' => 'array',
            'mlce_outcome' => 'array',
            'executive_summary' => 'array',
        ];
    }
}
