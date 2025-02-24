<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class VideoUser extends Pivot
{
    public $timestamps = false;

    protected $table = 'video_user';

    protected $fillable = [
        'video_id',
        'user_id',
    ];

//    public function video(): BelongsTo {
//        return $this->belongsTo(Video::class);
//    }

//    public function user(): BelongsTo {
//        return $this->belongsTo(User::class);
//    }
}
