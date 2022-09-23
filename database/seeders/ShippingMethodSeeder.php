<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('shipping_methods')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ShippingMethod::create([
            'name' => 'Бесплатная доставка',
            'code' => 'free',
            'price' => 0,
            'status' => 1,
            'order_min_price' => 0,
            'order_max_price' => 5000000000,
            'order' => 10,
        ]);

        ShippingMethod::create([
            'name' => 'Самовывоз',
            'code' => 'pickup',
            'price' => 0,
            'status' => 1,
            'order_min_price' => 0,
            'order_max_price' => 5000000000,
            'order' => 20,
        ]);

        // ShippingMethod::create([
        //     'name' => 'Standard',
        //     'code' => 'standard',
        //     'price' => 15000,
        //     'status' => 1,
        //     'order_min_price' => 0,
        //     'order_max_price' => 499999.99,
        //     'order' => 30,
        // ]);
    }
}
