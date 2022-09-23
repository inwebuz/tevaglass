<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products fields';

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
        $dateTime = now()->subHour();
        $products = Product::where('updated_at', '>', $dateTime)->get();
        foreach($products as $product) {
            $partnersPrices = Helper::partnersPrices($product->current_price);
            $productMinPricePerMonth = $product->current_price;
            $productMinPricePerMonthDuration = 0;
            foreach ($partnersPrices as $item) {
                if (empty($item['prices'])) {
                    continue;
                }
                foreach ($item['prices'] as $key => $itemPrice) {
                    if ($itemPrice['price_per_month'] < $productMinPricePerMonth) {
                        $productMinPricePerMonth = $itemPrice['price_per_month'];
                        $productMinPricePerMonthDuration = $itemPrice['duration'];
                    }
                }
            }
            $product->min_price_per_month = $productMinPricePerMonth;
            $product->min_price_per_month_duration = $productMinPricePerMonthDuration;

            Product::withoutEvents(function () use ($product) {
                $product->save();
            });
        }
        return 0;
    }
}
