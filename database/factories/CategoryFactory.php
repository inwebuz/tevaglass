<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $wordCount = mt_rand(1, 3);
        $title = Str::title(implode(' ', $this->faker->words($wordCount)));
        $imgNumber = mt_rand(1, 4);
        if ($imgNumber < 10) {
            $imgNumber = '0' . $imgNumber;
        }
        return [
            'name' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph,
            // 'description' => 'Короткое описание ...',
            'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(4)) . '</p>',
            // 'body' => '<p>Полное описание ...</p>',
            'status' => 1,
            'image' => 'categories/' . $imgNumber . '.jpg',
            // 'icon' => 'categories/icon-01.png',
            'show_in' => 1,
        ];
    }
}
