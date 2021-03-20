<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Haswallet extends Model
{
    use HasFactory;

    protected $fillable = ['bleyt_id','userID'];
}
