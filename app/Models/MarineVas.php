<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarineVas extends Model
{
    use HasFactory;

    protected $table = 'marine_vas';

    protected $fillable = [
        'title',
        'content',
    ];
}
