<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentPhoto extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'mlce_assignment_id',

        'title',
        'description',
    ];

    public function mlceAssignment(): BelongsTo {
        return $this->belongsTo(MlceAssignment::class);
    }
}
