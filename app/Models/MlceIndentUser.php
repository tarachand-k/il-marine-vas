<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MlceIndentUser extends Pivot
{
    public $incrementing = true;

    protected $table = 'mlce_indent_user';

    protected $fillable = [
        'mlce_indent_id',
        'user_id',

        'type',
    ];
}
