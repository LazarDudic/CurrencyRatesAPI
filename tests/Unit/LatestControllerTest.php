<?php

namespace Tests\Unit;

use Tests\TestCase;

class LatestControllerTest extends TestCase
{
    /** @test */
    public function action_index_passes()
    {
        $response = $this->get('api/latest');

        $response->assertStatus(200);
    }

    /** @test */
    public function action_index_fails_with_fake_base()
    {
        $response = $this->get('api/latest?base=ABC');

        $response->assertStatus(400);
    }

    /** @test */
    public function action_index_fails_with_fake_symbols()
    {
        $response = $this->get('/api/latest?symbols=ABC,USD');

        $response->assertStatus(400);
    }

    /** @test */
    public function action_index_fails_with_passes_with_valid_base()
    {
        $response = $this->get('/api/latest?base=USD');

        $response->assertStatus(200);
    }

    /** @test */
    public function action_index_fails_with_passes_with_valid_symbols()
    {
        $response = $this->get('/api/latest?symbols=USD,CAD');

        $response->assertStatus(200);
    }
}
