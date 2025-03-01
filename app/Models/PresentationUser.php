<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PresentationUser extends Pivot
{
    public $timestamps = false;

    protected $table = 'presentation_user';

    protected $fillable = [
        'presentation_id',
        'user_id',
    ];

//    public function presentation(): BelongsTo {
//        return $this->belongsTo(Presentation::class);
//    }
//
//    public function user(): BelongsTo {
//        return $this->belongsTo(User::class);
//    }
}
