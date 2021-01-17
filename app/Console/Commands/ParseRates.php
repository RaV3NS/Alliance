<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ParseRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse fiat and crypto rates';

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
     * Parse Fiat Rates From Privat24 API
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function parseFiat() {
        $client = new Client();
        $raw = $client->get('https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5')->getBody();
        $result = json_decode($raw, 1);

        foreach ($result as $rate) {
            if (in_array($rate['ccy'], config('currencies.fiat')))
                DB::table('rates')->updateOrInsert(
                    ['name' => $rate['ccy']],
                    [
                        'name' => $rate['ccy'],
                        'rate' => $rate['sale'],
                        'type' => 'fiat'
                    ]
                );
        }
    }

    public function parseCrypto() {
        $client = new Client();
        foreach (config('currencies.crypto') as $rate) {
            $raw = $client->get('https://rest.coinapi.io/v1/exchangerate/'. $rate .'/UAH',
                ['headers' => ['X-CoinAPI-Key' => env('COINAPI_KEY')]])->getBody();
            $result = json_decode($raw, 1);

            DB::table('rates')->updateOrInsert(
                ['name' => $result['asset_id_base']],
                [
                    'name' => $result['asset_id_base'],
                    'rate' => $result['rate'],
                    'type' => 'crypto'
                ]
            );
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->parseFiat();
        $this->parseCrypto();

        DB::table('rates')->insertOrIgnore(
            [
                'name' => 'UAH',
                'rate' => 1,
                'type' => 'fiat'
            ]
        );
    }
}
