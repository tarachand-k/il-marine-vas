<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyMlce extends Model
{
    use HasFactory;

    protected $table = 'why_mlce';

    protected $fillable = [
        'title',
        'content',
    ];
}
