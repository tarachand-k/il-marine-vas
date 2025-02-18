<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MlceIndentLocation extends Model
{
    use HasFactory, Filterable;

    public $filterFields = [
        'mlce_indent_id',

        'location',
        'spoc_name',
        'spoc_email',
        'spoc_mobile_no',
        'spoc_whatsapp_no',
        'status',
    ];

    protected $fillable = [
        'mlce_indent_id',

        'location',
        'address',
        'spoc_name',
        'spoc_email',
        'spoc_mobile_no',
        'spoc_whatsapp_no',
        'google_map_link',
        'status',
    ];

    public function mlceIndent(): BelongsTo {
        return $this->belongsTo(MlceIndent::class);
    }
}
