<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheduled_date',
        'scheduled_time',
        'private',
        'patient_id',
        'doctor_id',
    ];

    protected $dates = [
        'scheduled_date',
    ];
    protected $casts = [
        'private' => 'boolean',
        'scheduled_date' => 'datetime:d/m/Y',
    ];

    protected $with = [
        'patient',
        'doctor',
        'procedures',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function procedures()
    {
        return $this->belongsToMany(Procedure::class);
    }

    /**
     * Interact with the user's first name.
     *
     * @return Attribute
     */
    protected function scheduledDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn ($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }
}
