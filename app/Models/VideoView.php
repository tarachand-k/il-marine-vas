<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'video_id',
        'user_id',
        'viewed_at',
    ];

    public function video(): BelongsTo {
        return $this->belongsTo(Video::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
