<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenenfitData extends Model
{
    use HasFactory;
    protected $casts = [
        'selectedSources' => 'array'
    ];
}
