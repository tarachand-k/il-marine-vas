<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'mlce_report_id',
        'user_id',

        'page_name',
        'viewed_at',
        'device_info',
        'ip_address',
    ];

    // automatically set the `viewed_at` value when a new report view is created
    protected static function boot(): void {
        parent::boot();

        static::creating(function ($model) {
            // If viewed_at is not already set, set it to the current timestamp
            if (!$model->viewed_at) {
                $model->viewed_at = now()->format('Y-m-d H:i:s');
            }
        });
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
