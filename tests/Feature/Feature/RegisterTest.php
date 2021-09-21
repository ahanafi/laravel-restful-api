<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_successfully()
    {
        $payload = [
            'name' => 'hanafi',
            'email' => 'hanafi@test.com',
            'password' => '12345677',
            'password_confirmation' => '12345677'
        ];

        $this->json('POST', 'api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token'
                ]
            ]);
    }

    public function test_requirs_email_name_and_password()
    {
        $this->json('post', '/api/register')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    public function test_require_password_confirmation()
    {
        $payload = [
            'name' => 'Hanafi',
            'email' => 'hanafi@mail.com',
            'password' => '12345678',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => [
                        'The password confirmation does not match.'
                    ],
                ]
            ]);
    }
}
