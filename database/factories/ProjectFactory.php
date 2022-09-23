<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ProjectFactory extends Factory
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
        $imgNumber = mt_rand(1, 7);
        return [
            'name' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph,
            // 'description' => 'Короткое описание ...',
            'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(4)) . '</p>',
            // 'body' => '<p>Полное описание ...</p>',
            'status' => 1,
            'image' => 'projects/0' . $imgNumber . '.jpg',
            'type' => Arr::random(array_keys(Project::types())),
        ];
    }
}
