<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'date_of_birth',
        'weight',
        'image',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
