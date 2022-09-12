<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'crm',
        'specialty_id',
    ];

    protected $with = [
        'specialty',
    ];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
