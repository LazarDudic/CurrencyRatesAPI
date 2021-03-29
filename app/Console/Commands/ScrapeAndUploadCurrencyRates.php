<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Services\Scraper;
use Illuminate\Console\Command;

class ScrapeAndUploadCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle()
    {
        $scraper = new Scraper();
        $currencies = $scraper->getCurrency();

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
