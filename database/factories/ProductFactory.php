<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $wordCount = mt_rand(2, 8);
        // $title = Str::title(implode(' ', $this->faker->words($wordCount)));
        $titles = ['Aluminum windows', 'Guillotine Window System', ];
        $descriptions = ['Aluminium thermal break system suitable for flexibility and comfort. Through the use of new materials and technologies, like low emissivity film covered polyamide bars and the new main gasket in expanded EPDM, it ensures excellent thermal and acoustic standards.', 'VertiFlex is a remote-controlled, motorized, chained, movable handrail glazing system. This guillotine system has been developed the full panoramic view as its designed with no frames.', ];
        $randKey = array_rand($titles);
        $title = $titles[$randKey];
        $description = $descriptions[$randKey];
        // $category = Category::inRandomOrder()->first();
        $price = mt_rand(50, 500) * 1000;
        $imgNumber = mt_rand(1, 4);
        $random10 = mt_rand(0, 9);
        $brand = Brand::inRandomOrder()->first();

        $product = [
            'name' => $title,
            'slug' => Str::slug($title),
            // 'description' => $this->faker->paragraph,
            // 'description' => 'Короткое описание ...',
            'description' => $description,
            'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(4)) . '</p>',
            // 'body' => '<p>Полное описание ...</p>',
            'status' => 1,
            // 'specifications' => '<p>' . implode('</p><p>', $this->faker->paragraphs(4)) . '</p>',
            'specifications' => '',
            // 'category_id' => $category->id,
            // 'brand_id' => $brand->id,
            // 'installment_price' => $price * 1.2,
            'price' => $price,
            'sale_price' => in_array($random10, [6, 7]) ? $price * 0.9 : 0,
            'image' => 'products/0' . $imgNumber . '.jpg',
            // 'images' => '["products//gallery-01.png","products//gallery-02.png","products//gallery-03.png"]',
            'images' => '["products//gallery-01.jpg"]',
            'in_stock' => mt_rand(0, 9),
            'is_bestseller' => $random10 == 9 ? 1 : 0,
            //'is_featured' => $random10 == 9 ? 1 : 0,
            'is_new' => $random10 == 8 ? 1 : 0,
            'is_promotion' => $random10 == 7 ? 1 : 0,
            'sku' => $this->faker->uuid,
        ];

        return $product;
    }
}
