<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, Filterable;

    public $filterFields = [
        "rm_id",
        "under_writer_id",
        "channel_partner_id",

        "name",
        "email",
        "mobile_no",
        'policy_no',
        'policy_type',
        'policy_start_date',
        'policy_end_date',
        "account_type",
    ];

    protected $fillable = [
        "rm_id",
        "under_writer_id",
        "channel_partner_id",

        "name",
        "email",
        "mobile_no",
        'policy_no',
        'policy_type',
        'policy_start_date',
        'policy_end_date',
        "account_type",
        "address",
        "about",
        "coverage_terms",
        "cargo_details",
        "transit_details",
    ];

    public function users(): HasMany {
        return $this->hasMany(User::class, 'customer_id');
    }

    public function rm(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function underWriter(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function channelPartner(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
