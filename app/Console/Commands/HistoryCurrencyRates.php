<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Console\Command;

class HistoryCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'history:currency-rates';

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

        $currencyRates = Currency::whereDate('created_at', Carbon::today())->get(['name', 'rate']);

        foreach ($currencyRates as $currency) {
            $rates[$currency->name] = $currency->rate;
        }

        History::create([
            'rates' => json_encode($rates),
        ]);
    }
}
