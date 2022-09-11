<?php

namespace Tests\Feature;

use App\Http\Resources\PatientCollection;
use App\Http\Resources\PatientResource;
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

        $this->actingAs($user)
            ->postJson(route('patients.store'), $patient->toArray())
            ->assertStatus(201)
            ->assertJsonStructure(array_keys($patient->toArray()));

        $this->assertDatabaseCount('patients', 1);
    }

    public function test_if_patients_is_updating()
    {
        $user = User::factory()->create();

        $patient = Patient::factory();

        $createdPatient = $patient->create();
        $differentPatient = $patient->make();

        $this->actingAs($user)
            ->patchJson(route('patients.update', $createdPatient->id), $differentPatient->toArray())
            ->assertStatus(200)
            ->assertJsonStructure(array_keys($differentPatient->toArray()))
            ->assertJson($differentPatient->toArray())
            ->assertJsonMissingExact($createdPatient->toArray());
    }

    public function test_if_patients_is_deleting()
    {
        $user = User::factory()->create();

        $patient = Patient::factory()->create();

        $this->actingAs($user)
            ->deleteJson(route('patients.destroy', $patient->id))
            ->assertStatus(204);

        $this->assertDatabaseCount('patients', 0);
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
}
