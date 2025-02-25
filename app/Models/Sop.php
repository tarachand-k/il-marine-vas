<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sop extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'customer_id',

        'pdf',
        'start_date',
        'end_date',
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }
}
