<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presentation extends Model
{
    use HasFactory;

    protected $attributes = [
        "view_count" => 0,
    ];

    protected $fillable = [
        'uploaded_by_id',

        'title',
        'description',
        'presentation',
        'view_count',
    ];

    public function uploadedBy(): BelongsTo {
        return $this->belongsTo(User::class, 'uploaded_by_id');
    }

    public function allowedUsers(): BelongsToMany {
        return $this->belongsToMany(User::class, 'presentation_user');
    }

    public function views(): HasMany {
        return $this->hasMany(PresentationView::class, 'presentation_id');
    }
}
