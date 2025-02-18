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
        "policy_no",
        "coverage_from",
        "coverage_to",
    ];

    protected $fillable = [
        "name",
        "email",
        "mobile_no",
        "policy_no",
        "policy_type",
        "coverage_from",
        "coverage_to",
        "about",
        "coverage_terms",
        "cargo_details",
        "transit_details",
    ];
}
