<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function healthInsurances()
    {
        return $this->belongsToMany(HealthInsurance::class)->withPivot('contract_number');
    }

    /**
     * Interact with the user's first name.
     *
     * @return Attribute
     */
    protected function birthday(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn ($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }
}
