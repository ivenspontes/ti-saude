<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class jwtTest extends TestCase
{
    use refreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_if_login_route_is_accessible()
    {
        $response = $this->post(route('jwt.auth.login'));

        $response->assertStatus(422);
    }

    public function test_if_auth_attempt_is_working()
    {
        $user = User::factory()->create();

        $this->assertNotFalse(auth()->attempt([
            'email' => $user->email,
            'password' => 'password'
        ]));
    }

    public function test_always_pass_in_login_validation()
    {
        $response = $this->postJson(route('jwt.auth.login'), [
            'email' => 'email@email.com',
            'password' => 'password'
        ]);

        $response->assertStatus(401);
    }

    public function test_always_fail_in_login_validation()
    {
        $response = $this->postJson(route('jwt.auth.login'));

        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_empty_email_input_in_login_validation()
    {
        $response = $this->postJson(route('jwt.auth.login'), [
            'email' => '',
        ]);

        $response->assertJsonValidationErrors(['email']);

        $response = $this->postJson(route('jwt.auth.login'));

        $response->assertJsonValidationErrors(['email']);
    }

    public function test_email_input_without_at_in_login_validation()
    {
        $response = $this->postJson(route('jwt.auth.login'), [
            'email' => 'email',
        ]);

        $response->assertJsonValidationErrors(['email']);
    }

    public function test_max_email_input_in_login_validation()
    {
        $response = $this->postJson(route('jwt.auth.login'), [
            'email' => Str::random(246) . '@email.com'
        ]);

        $response->assertJsonValidationErrors(['email']);
    }

    public function test_min_password_input_in_login_validation()
    {
        $response = $this->postJson(route('jwt.auth.login'), [
            'password' => Str::random(7),
        ]);

        $response->assertJsonValidationErrors(['password']);
    }

    public function test_empty_password_input_in_login_validation()
    {
        $response = $this->postJson(route('jwt.auth.login'), [
            'password' => '',
        ]);

        $response->assertJsonValidationErrors(['password']);

        $response = $this->postJson(route('jwt.auth.login'));

        $response->assertJsonValidationErrors(['password']);
    }

    public function test_if_login_route_is_returning_token()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('jwt.auth.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }

    public function test_if_logout_route_is_not_accessible_by_guest()
    {
        $response = $this->postJson(route('jwt.auth.logout'));

        $response->assertStatus(401);
    }

    public function test_if_me_route_is_not_accessible_by_guest()
    {

        $response = $this->postJson(route('jwt.auth.me'));

        $response->assertStatus(401);
    }

    public function test_if_refresh_route_is_not_accessible_by_guest()
    {

        $response = $this->postJson(route('jwt.auth.refresh'));

        $response->assertStatus(401);
    }

    public function test_if_logout_route_is_loging_out_user()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson(route('jwt.auth.logout'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out',
            ]);
    }

    public function test_if_me_route_is_returning_user()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson(route('jwt.auth.me'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at->jsonSerialize(),
                'created_at' => $user->created_at->jsonSerialize(),
                'updated_at' => $user->updated_at->jsonSerialize()
            ])
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at'
            ]);
    }

    public function test_if_refresh_route_is_refreshing_token()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson(route('jwt.auth.refresh'));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }
}
