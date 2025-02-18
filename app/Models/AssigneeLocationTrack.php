<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssigneeLocationTrack extends Model
{
    use HasFactory, Filterable;

    public $filterFields = [
        'mlce_assignment_id',

        'status',
        'latitude',
        'longitude',
        'battery_level',
    ];

    protected $fillable = [
        'mlce_assignment_id',

        'status',
        'latitude',
        'longitude',
        'battery_level',
    ];

    public function mlceAssignment(): BelongsTo {
        return $this->belongsTo(MlceAssignment::class);
    }
}
