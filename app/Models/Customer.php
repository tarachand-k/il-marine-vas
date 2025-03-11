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
        "transit_coverage_from",
        "transit_coverage_to",
    ];

    protected $fillable = [
        "name",
        "email",
        "mobile_no",
        "transit_coverage_from",
        "transit_coverage_to",
        "about",
        "coverage_terms",
        "cargo_details",
        "transit_details",
    ];

    public function users(): HasMany {
        return $this->hasMany(User::class, 'customer_id');
    }

    public function mlceRecommendations(): HasMany {
        return $this->hasMany(MlceRecommendation::class, 'customer_id');
    }

    protected function casts(): array {
        return [
            'about' => 'array',
            'coverage_terms' => 'array',
            'cargo_details' => 'array',
            'transit_details' => 'array',
        ];
    }
}
