<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birthday',
        'phones',
    ];

    protected $dates = ['birthday'];

    protected $casts = [
        'birth_date' => 'date',
        'phones' => 'array',
    ];
}
