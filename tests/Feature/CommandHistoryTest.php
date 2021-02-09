<?php

namespace Tests\Feature;

use App\Models\Currency;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function command_creates_new_history()
    {
        Currency::factory(32)->create();
        $currencyRates = Currency::whereDate('created_at', Carbon::today())->get(['name', 'rate']);

        foreach ($currencyRates as $currency) {
            $rates[$currency->name] = $currency->rate;
        }
        History::create([
            'rates' => json_encode($rates),
        ]);

        $this->assertEquals(1, History::all()->count());
    }
}
