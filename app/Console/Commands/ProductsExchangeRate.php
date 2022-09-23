<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProductsExchangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:exchange_rate {direction}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products price';

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
     */
    public function handle()
    {
        $direction = $this->argument('direction');
        $exchangeRate = Helper::exchangeRate();

        Product::chunk(200, function ($products) use ($direction, $exchangeRate) {
            foreach ($products as $product) {
                $product->price = $this->updatePrice($direction, $product->price, $exchangeRate);
                $product->sale_price = $this->updatePrice($direction, $product->sale_price, $exchangeRate);
                $product->installment_price = $this->updatePrice($direction, $product->installment_price, $exchangeRate);
                $product->min_price_per_month = $this->updatePrice($direction, $product->min_price_per_month, $exchangeRate);
                $product->saveQuietly();
            }
        });
        return 0;
    }

    private function updatePrice($direction, $price, $exchangeRate)
    {
        switch ($direction) {
            case 'uzs_usd':
                $price = $price / $exchangeRate;
                break;

            case 'usd_uzs':
                $price = $price * $exchangeRate;
                break;
        }
        return $price;
    }
}
