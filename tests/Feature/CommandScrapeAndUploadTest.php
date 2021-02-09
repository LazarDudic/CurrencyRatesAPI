<?php

namespace Tests\Feature;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandScrapeAndUploadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function command_creates_new_rate()
    {
        $this->artisan('scrape:upload');
        $currency = Currency::all();
        $this->assertEquals(1, $currency->count());
    }


}
