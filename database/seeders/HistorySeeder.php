<?php

namespace Database\Seeders;

use App\Models\History;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $currencies = ['CAD', 'HKD', 'ISK', 'PHP', 'DKK', 'HUF', 'CZK', 'AUD', 'RON'
            , 'SEK', 'IDR', 'INR', 'BRL', 'RUB', 'HRK', 'JPY', 'THB', 'CHF', 'SGD', 'PLN'
            , 'BGN', 'TRY', 'CNY', 'NOK', 'NZD', 'ZAR', 'USD', 'MXN', 'ILS', 'GBP', 'KRW', 'MYR'
        ];

        foreach ($currencies as $currency) {
            $data[$currency] = $faker->randomFloat(4, 0.1, 50);
        }

        $data = json_encode($data);

        History::create([
            'rates' => $data
        ]);
        History::create([
            'rates' => $data,
            'created_at' => Carbon::yesterday()
        ]);
    }
}
