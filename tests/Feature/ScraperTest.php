<?php

namespace Tests\Feature;

use App\Models\Currency;
use App\Services\Scraper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ScraperTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_if_scraper_set_name()
    {
        $scraper = new Scraper();
        $currencyName = $scraper->getCurrencyName();

        $this->assertEquals(3, strlen($currencyName));
    }

    /** @test */
    public function test_if_scraper_set_rate()
    {
        $scraper = new Scraper();
        $rate = $scraper->getCurrencyRate();

        $this->assertIsNumeric($rate);
    }
}
