<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected function casts(): array {
        return [
            'about' => 'array',
            'coverage_terms' => 'array',
            'cargo_details' => 'array',
            'transit_details' => 'array',
        ];
    }
}
