<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SopView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'sop_id',
        'user_id',

        'viewed_at',
    ];

    public function sop(): BelongsTo {
        return $this->belongsTo(Sop::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
