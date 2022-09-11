<?php

namespace Tests\Feature;

use App\Http\Resources\HealthInsuranceCollection;
use App\Http\Resources\HealthInsuranceResource;
use App\Models\HealthInsurance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class HealthInsuranceTest extends TestCase
{
    use refreshDatabase;

    public function test_if_health_insurances_index_route_is_accessible()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('health-insurances.index'));

        $response->assertStatus(200);
    }

    public function test_health_insurances_index_returned_data()
    {
        $user = User::factory()->create();

        HealthInsurance::factory(30)->create();

        $request = Request::create(route('health-insurances.index'));

        $this->actingAs($user)
            ->getJson(route('health-insurances.index'))
            ->assertStatus(200)
            ->assertExactJson((new HealthInsuranceCollection(HealthInsurance::simplePaginate()))->response($request)->getData(true));
    }

    public function test_health_insurances_show_returned_data()
    {
        $user = User::factory()->create();

        $healthInsurance = HealthInsurance::factory()->create();

        $request = Request::create(route('health-insurances.show', $healthInsurance->id));

        $this->actingAs($user)
            ->getJson(route('health-insurances.show', $healthInsurance->id))
            ->assertStatus(200)
            ->assertExactJson((new HealthInsuranceResource($healthInsurance))->response($request)->getData(true));
    }

    public function test_if_health_insurances_is_storing()
    {
        $user = User::factory()->create();

        $healthInsurance = HealthInsurance::factory()->make();

        $this->actingAs($user)
            ->postJson(route('health-insurances.store'), $healthInsurance->toArray())
            ->assertStatus(201)
            ->assertJsonStructure(array_keys($healthInsurance->toArray()));

        $this->assertDatabaseCount('health_insurances', 1);
    }

    public function test_if_health_insurances_is_updating()
    {
        $user = User::factory()->create();

        $healthInsurance = HealthInsurance::factory();

        $createdHealthInsurance = $healthInsurance->create();
        $differentHealthInsurance = $healthInsurance->make();

        $this->actingAs($user)
            ->patchJson(route('health-insurances.update', $createdHealthInsurance->id), $differentHealthInsurance->toArray())
            ->assertStatus(200)
            ->assertJsonStructure(array_keys($differentHealthInsurance->toArray()))
            ->assertJson($differentHealthInsurance->toArray())
            ->assertJsonMissingExact($createdHealthInsurance->toArray());
    }

    public function test_if_health_insurances_is_deleting()
    {
        $user = User::factory()->create();

        $healthInsurance = HealthInsurance::factory()->create();

        $this->actingAs($user)
            ->deleteJson(route('health-insurances.destroy', $healthInsurance->id))
            ->assertStatus(204);

        $this->assertDatabaseCount('health_insurances', 0);
    }

    public function test_if_patients_store_route_is_validating_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('health-insurances.store'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description', 'phone']);
    }

    public function test_if_patients_store_route_is_validating_string()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('health-insurances.store'), [
                'description' => 123,
                'phone' => 123,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description', 'phone']);
    }
}
