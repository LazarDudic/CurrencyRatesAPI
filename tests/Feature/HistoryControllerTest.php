<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class HistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void{
        parent::setUp();
        $this->artisan('db:seed');
        Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    /** @test */
    public function history_controller_index_passes()
    {
        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $response = $this->get(
            'api/history?start_at='.$yesterday.'&end_at='.$today.'&base=USD&symbols=CAD,PHP'
        );

    }

    /** @test */
    public function history_controller_show_passes()
    {
        $today = Carbon::today()->format('Y-m-d');
        $response = $this->get('api/history/'.$today.'?base=USD&symbols=CAD,EUR');

        $response->assertStatus(200);
    }

    /** @test */
    public function history_controller_index_time_required()
    {
        $response = $this->get('api/history?base=USD&symbols=CAD,PHP');

        $response->assertStatus(400);
    }

    /** @test */
    public function history_controller_index_data_for_specific_time_not_found()
    {
        $twoYearsAgo = Carbon::today()->subYears(2)->format('Y-m-d');
        $threeYearsAgo = Carbon::today()->subYears(3)->format('Y-m-d');
        $response = $this->get(
            'api/history?start_at='.$threeYearsAgo.'&end_at='.$twoYearsAgo
        );

        $response->assertStatus(404);
    }

}
