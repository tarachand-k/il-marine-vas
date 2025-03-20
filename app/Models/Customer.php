<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, Filterable;

    public $filterFields = [
        "name",
        "email",
        "mobile_no",
        'policy_no',
        'policy_type',
        'policy_start_date',
        'policy_end_date',
        "transit_coverage_from",
        "transit_coverage_to",
    ];

    protected $fillable = [
        "name",
        "email",
        "mobile_no",
        'policy_no',
        'policy_type',
        'policy_start_date',
        'policy_end_date',
        "about",
        "coverage_terms",
        "cargo_details",
        "transit_details",
    ];

    public function users(): HasMany {
        return $this->hasMany(User::class, 'customer_id');
    }
}
