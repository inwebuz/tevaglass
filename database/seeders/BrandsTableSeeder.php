<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('brands')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Brand::factory()->create([
            'name' => 'LG',
            'slug' => Str::slug('LG'),
            'image' => 'brands/01.jpg',
        ]);

        Brand::factory()->create([
            'name' => 'Canon',
            'slug' => Str::slug('Canon'),
            'image' => 'brands/02.jpg',
        ]);

        Brand::factory()->create([
            'name' => 'HP',
            'slug' => Str::slug('HP'),
            'image' => 'brands/03.jpg',
        ]);
    }
}
