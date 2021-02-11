<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    private $user;

    public function setUp(): void{
        parent::setUp();
        $this->post('api/register', [
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => 'password'
        ]);

        $this->user = User::where('email', 'user@email.com')->first();
    }

    /** @test */
    public function user_login_successfully()
    {
        $response = $this->post('api/login', [
            'email' => 'user@email.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function user_get_access_token_after_login()
    {
        $response = $this->post('api/login', [
            'email' => 'user@email.com',
            'password' => 'password'
        ]);

        $response->assertSee('access_token');
    }
}
