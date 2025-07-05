<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MlceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'date',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    protected function casts(): array {
        return [
            'date' => 'date',
        ];
    }
}
