<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BrandFactory extends Factory
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
        return [
            'name' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph,
            // 'description' => 'Короткое описание ...',
            'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(4)) . '</p>',
            // 'body' => '<p>Полное описание ...</p>',
            'status' => 1,
        ];
    }
}
