<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresentationView extends Model
{
    use HasFactory, Filterable;

    public $timestamps = false;

    public $filterFields = [
        "presentation_id",
        "user_id",

        "viewed_at",
    ];

    protected $fillable = [
        'presentation_id',

        'user_id',
        'viewed_at',
    ];

    public function presentation(): BelongsTo {
        return $this->belongsTo(Presentation::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
