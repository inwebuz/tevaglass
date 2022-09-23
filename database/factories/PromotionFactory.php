<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $word = Str::title($this->faker->sentence);
        //$rubric = Rubric::inRandomOrder()->first();
        $start = now()->subDays(3)->addDays(mt_rand(0, 5));
        $end = clone $start;
        $end->addDays(2);
        $data = [
            'name' => $word,
            'slug' => Str::slug($word),
            'description' => $this->faker->paragraph,
            'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(6)) . '</p>',
            'status' => 1,
            'image' => 'promotions/00' . mt_rand(1, 4) . '.jpg',
            'start_at' => $start->startOfDay(),
            'end_at' => $end->endOfDay(),
        ];

        return $data;
    }
}
