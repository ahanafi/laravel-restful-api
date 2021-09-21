<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_is_loggout_properly()
    {
        $user = User::factory()->create([
            'name' => 'Ahmad',
            'email' => 'ahmad@test.com',
            'password' => '123456678'
        ]);
        $token = $user->generateToken();

        $headers = [
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $this->json('get', 'api/articles', [], $headers)
            ->assertStatus(200);
        $this->json('post', 'api/logout', [], $headers)
            ->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

    public function test_user_with_null_token()
    {
        $user = User::factory()->create(['email' => 'ahmad@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => 'Barear ' . $token];

        $user->api_token = null;
        $user->save();

        $this->json('GET', 'api/articles', [], $headers)
            ->assertStatus(401);
    }
}
