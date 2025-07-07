<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExecutiveSummaryPhoto extends Model
{
    protected $fillable = [
        'mlce_indent_id',
        'description',
        'photo',
    ];

    public function mlceIndent(): BelongsTo
    {
        return $this->belongsTo(ExecutiveSummary::class, 'mlce_indent_id');
    }
}
