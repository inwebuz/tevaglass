<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('payment_methods')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        PaymentMethod::create([
            'name' => 'Наличные',
            'code' => 'cash',
            'status' => 1,
            'app' => 1,
            'desktop' => 1,
            'installment' => 0,
            'order' => 10,
        ]);

        PaymentMethod::create([
            'name' => 'Картой онлайн',
            'code' => 'card',
            'status' => 1,
            'app' => 1,
            'desktop' => 1,
            'installment' => 0,
            'order' => 20,
        ]);
    }
}
