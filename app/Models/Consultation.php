<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Consultation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'scheduled_date',
        'scheduled_time',
        'private',
        'patient_id',
        'doctor_id',
    ];

    /**
     * The attributes that should be date
     *
     * @var array<string, Attribute>
     */
    protected $dates = [
        'scheduled_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, Attribute>
     */
    protected $casts = [
        'private' => 'boolean',
        'scheduled_date' => 'datetime:d/m/Y',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'patient',
        'doctor',
        'procedures',
    ];

    /**
     * Get the patient that owns the Consultation
     *
     * @return BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor that owns the Consultation
     *
     * @return BelongsTo
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * The procedures that belong to the Consultation
     *
     * @return BelongsToMany
     */
    public function procedures(): BelongsToMany
    {
        return $this->belongsToMany(Procedure::class);
    }

    /**
     * Interact with the Consultation's schedule date.
     *
     * @return Attribute
     */
    protected function scheduledDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }
}
