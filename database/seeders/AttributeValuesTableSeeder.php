<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('attribute_values')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Color
        AttributeValue::factory()->create([
            'attribute_id' => 2,
            'name' => 'Белый',
            'used_for_filter' => 1,
            'color' => '#ffffff',
            'is_light_color' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 2,
            'name' => 'Черный',
            'used_for_filter' => 1,
            'color' => '#000000',
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 2,
            'name' => 'Красный',
            'used_for_filter' => 1,
            'color' => '#DE1F16',
        ]);
        // AttributeValue::factory()->create([
        //     'attribute_id' => 2,
        //     'name' => 'Зеленый',
        //     'used_for_filter' => 1,
        //     'color' => '#8BC34C',
        // ]);
        AttributeValue::factory()->create([
            'attribute_id' => 2,
            'name' => 'Серый',
            'used_for_filter' => 1,
            'color' => '#BABAC0',
        ]);
        // AttributeValue::factory()->create([
        //     'attribute_id' => 2,
        //     'name' => 'Голубой',
        //     'used_for_filter' => 1,
        //     'color' => '#73BFEB',
        // ]);
        AttributeValue::factory()->create([
            'attribute_id' => 2,
            'name' => 'Золотой',
            'used_for_filter' => 1,
            'color' => '#FFD75F',
        ]);

        AttributeValue::factory()->create([
            'attribute_id' => 3,
            'name' => '8GB',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 3,
            'name' => '16GB',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 3,
            'name' => '32GB',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 3,
            'name' => '64GB',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 3,
            'name' => '128GB',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 3,
            'name' => '256GB',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 3,
            'name' => '512GB',
            'used_for_filter' => 1,
        ]);

        AttributeValue::factory()->create([
            'attribute_id' => 4,
            'name' => '4.9”',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 4,
            'name' => '5.0”',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 4,
            'name' => '5.1”',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 4,
            'name' => '5.5”',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 4,
            'name' => '6.0”',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 4,
            'name' => '6.5”',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 4,
            'name' => '7.0”',
            'used_for_filter' => 1,
        ]);

        AttributeValue::factory()->create([
            'attribute_id' => 5,
            'name' => '24',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 5,
            'name' => '27',
            'used_for_filter' => 1,
        ]);

        AttributeValue::factory()->create([
            'attribute_id' => 6,
            'name' => 'A1',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 6,
            'name' => 'A2',
            'used_for_filter' => 1,
        ]);

        AttributeValue::factory()->create([
            'attribute_id' => 7,
            'name' => 'Есть',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 7,
            'name' => 'Нет',
            'used_for_filter' => 1,
        ]);

        AttributeValue::factory()->create([
            'attribute_id' => 8,
            'name' => 'iOS 12',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 8,
            'name' => 'iOS 13',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 8,
            'name' => 'iOS 14',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 8,
            'name' => 'Android 7',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 8,
            'name' => 'Android 8',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 8,
            'name' => 'Android 9',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 8,
            'name' => 'Android 10',
            'used_for_filter' => 1,
        ]);
        AttributeValue::factory()->create([
            'attribute_id' => 8,
            'name' => 'Android 11',
            'used_for_filter' => 1,
        ]);

        // Test
        // AttributeValue::factory()->count(5)->create([
        //     'attribute_id' => 3,
        //     'used_for_filter' => 1,
        // ]);

        // Random
        // AttributeValue::factory()->count(5)->create([
        //     'attribute_id' => 3,
        // ]);
    }
}
