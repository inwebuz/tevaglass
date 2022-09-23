<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $word = Str::title($this->faker->sentence);
        $data = [
            'name' => $word,
            'slug' => Str::slug($word),
            'description' => $this->faker->paragraph,
            'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(6)) . '</p>',
            'status' => 1,
            'image' => 'stores/0' . mt_rand(1, 4) . '.jpg',
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'landmark' => $this->faker->word(),
            'work_hours' => '9:00 - 18:00',
            'map_code' => '<iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A90b83881397d5acb3f298b740beb68f5f05a341987b83afaefbb2cdf77c9d23c&amp;source=constructor" width="500" height="400" frameborder="0"></iframe>',
            'latitude' => $this->faker->latitude(40, 42),
            'longitude' => $this->faker->longitude(68, 70),
        ];

        return $data;
    }
}
