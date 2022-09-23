<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('projects')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Project::factory()->count(10)->create([
            'name' => 'IT PARK',
            'slug' => Str::slug('IT PARK'),
            'description' => 'A full range of services including most of the products presented on the site. This project is of particular importance due to the construction of the first international branch',
            'short_info' => 'Doors, partitions, windows',
        ])->each(function($project){
            // categories
            $products = Product::inRandomOrder()->take(2)->get();
            $project->products()->sync($products);
        });

    }
}
