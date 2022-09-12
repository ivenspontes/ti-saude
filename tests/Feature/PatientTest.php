<?php

namespace Tests\Feature;

use App\Http\Resources\PatientCollection;
use App\Http\Resources\PatientResource;
use App\Models\HealthInsurance;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_patients_index_route_is_accessible()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('patients.index'));

        $response->assertStatus(200);
    }

    public function test_patients_index_returned_data()
    {
        $user = User::factory()->create();

        $patients = Patient::factory(30)->create();

        $healthInsurances = HealthInsurance::factory(5)->create();

        $patients->each(function ($patient) use ($healthInsurances) {
            $healthInsurances->take(rand(1, 5))->each(function ($healthInsurance) use ($patient) {
                $patient->healthInsurances()->attach($healthInsurance, ['contract_number' => rand(100000, 999999)]);
            });
        });

        $request = Request::create(route('patients.index'));

        $this->actingAs($user)
            ->getJson(route('patients.index'))
            ->assertStatus(200)
            ->assertExactJson((new PatientCollection(Patient::simplePaginate()))->response($request)->getData(true));
    }

    public function test_patients_show_returned_data()
    {
        $user = User::factory()->create();

        $patient = Patient::factory()->create();

        $healthInsurances = HealthInsurance::factory(5)->create();

        $healthInsurances->take(rand(1, 5))->each(function ($healthInsurance) use ($patient) {
            $patient->healthInsurances()->attach($healthInsurance, ['contract_number' => rand(100000, 999999)]);
        });

        $request = Request::create(route('patients.show', $patient->id));

        $this->actingAs($user)
            ->getJson(route('patients.show', $patient->id))
            ->assertStatus(200)
            ->assertExactJson((new PatientResource($patient))->response($request)->getData(true));
    }

    public function test_if_patients_is_storing()
    {
        $user = User::factory()->create();

        $patient = Patient::factory()->make();

        $healthInsurances = HealthInsurance::factory(5)->create();

        $patientWithHealthInsurances = array_merge($patient->toArray(), ['health_insurances' => $healthInsurances->map(function ($healthInsurance) {
            return [
                'id' => $healthInsurance->id,
                'contract_number' => rand(100000, 999999),
            ];
        })->toArray()]);

        $this->actingAs($user)
            ->postJson(route('patients.store'), $patientWithHealthInsurances)
            ->assertStatus(201);

        $this->assertDatabaseCount('patients', 1);
    }

    public function test_if_patients_is_updating()
    {
        $user = User::factory()->create();

        $patient = Patient::factory();

        $createdPatient = $patient->create();

        $differentPatient = $patient->make();

        $healthInsurances = HealthInsurance::factory(5)->create();

        $patientWithHealthInsurances = array_merge($differentPatient->toArray(), ['health_insurances' => $healthInsurances->map(function ($healthInsurance) {
            return [
                'id' => $healthInsurance->id,
                'contract_number' => rand(100000, 999999),
            ];
        })->toArray()]);

        $this->actingAs($user)
            ->patchJson(route('patients.update', $createdPatient->id), $patientWithHealthInsurances)
            ->assertStatus(200);
    }

    public function test_if_patients_is_deleting()
    {
        $user = User::factory()->create();

        $patient = Patient::factory()->hasAttached(HealthInsurance::factory()->count(3), ['contract_number' => rand(1000, 9999)])->create();

        $this->actingAs($user)
            ->deleteJson(route('patients.destroy', $patient->id))
            ->assertStatus(200);

        $this->assertDatabaseCount('patients', 0);
        $this->assertDatabaseCount('health_insurance_patient', 0);
    }

    public function test_if_patients_store_route_is_validating_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('patients.store'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'phones', 'birthday']);
    }

    public function test_if_patients_store_route_is_validating_input_phones_array()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('patients.store'), ['phones' => 'not an array'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['phones']);
    }

    public function test_if_patients_store_route_is_validating_input_name_string()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('patients.store'), ['name' => 123])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_if_patients_store_route_is_validating_input_name_max()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('patients.store'), ['name' => Str::random(256)])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_if_patients_store_route_is_validating_input_birthday_date()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('patients.store'), ['birthday' => 'not a date'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['birthday']);
    }

    public function test_if_patients_store_route_is_validating_input_health_insurances_array()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('patients.store'), ['health_insurances' => 'not a array'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['health_insurances']);
    }

    public function test_if_patients_store_route_is_validating_input_health_insurances_id_integer()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('patients.store'), ['health_insurances' => ['1' => ['id' => 'a']]])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['health_insurances.1.id']);
    }

    public function test_if_patients_store_route_is_validating_input_health_insurances_id_exists()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('patients.store'), ['health_insurances' => ['1' => ['id' => 1]]])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['health_insurances.1.id']);
    }

    public function test_if_patients_store_route_is_validating_input_health_insurances_contract_number_integer()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('patients.store'), ['health_insurances' => ['1' => ['contract_number' => 'a']]])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['health_insurances.1.contract_number']);
    }
}
