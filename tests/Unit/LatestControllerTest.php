<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LatestControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void{
        parent::setUp();
        $this->artisan('db:seed');
        Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    /** @test */
    public function latest_controller_index_passes()
    {
        $response = $this->get('api/latest');

        $response->assertStatus(200);
    }

    /** @test */
    public function latest_controller_index_fails_with_fake_base()
    {
        $response = $this->get('api/latest?base=ABC');

        $response->assertStatus(400);
    }

    /** @test */
    public function latest_controller_index_fails_with_fake_symbols()
    {
        $response = $this->get('/api/latest?symbols=ABC,USD');

        $response->assertStatus(400);
    }

    /** @test */
    public function latest_controller_index_fails_with_passes_with_valid_base()
    {
        $response = $this->get('/api/latest?base=USD');

        $response->assertStatus(200);
    }

    /** @test */
    public function latest_controller_index_fails_with_passes_with_valid_symbols()
    {
        $response = $this->get('/api/latest?symbols=USD,CAD');

        $response->assertStatus(200);
    }
}
