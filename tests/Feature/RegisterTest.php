<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function registration_passes()
    {
        $response = $this->getUserRegisterResponse();

        $response->assertStatus(201);
    }

    /** @test */
    public function after_registration_user_get_json_data_about_himself()
    {
        $response = $this->getUserRegisterResponse();

        $response->assertSee(['name','email', 'created_at']);
    }


    private function getUserRegisterResponse()
    {
        $response = $this->post('api/register', [
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => 'password'
        ]);

        return $response;
    }
}
