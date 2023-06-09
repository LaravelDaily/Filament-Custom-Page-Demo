<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Match extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
