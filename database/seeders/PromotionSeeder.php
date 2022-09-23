<?php

namespace Database\Seeders;

use App\Models\Promotion;
use App\Pubrubric;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('promotions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Promotion::factory()->count(20)->create();
    }
}
