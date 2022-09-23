<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = Page::factory()->create([
            'name' => 'Home',
            'slug' => 'home',
            'order' => 0,
            'show_in' => 0,
        ]);

        $page = Page::factory()->create([
            'name' => 'Contacts',
            'slug' => 'contacts',
            'order' => 1000,
            'show_in' => 1,
            'description' => '',
            'body' => '',
        ]);

        $page = Page::factory()->create([
            'name' => 'About',
            'slug' => 'about',
            'order' => 40,
            'show_in' => 1,
            'image' => 'pages/about-short.jpg',
            'description' => 'For more than 14 years of manufacturing window and glass products the Teva Glass become one of the leaders of industry. Our specialists and artisans do their best to provide your home/office with high-quality goods for long-lasting service life. Day by day we improve the quality, design, and service of our company. '
        ]);

        $page = Page::factory()->create([
            'name' => 'Products',
            'slug' => 'products',
            'order' => 50,
            'show_in' => 2,
        ]);

        $page = Page::factory()->create([
            'name' => 'Portfolio',
            'slug' => 'portfolio',
            'order' => 60,
            'show_in' => 1,
        ]);

        $page = Page::factory()->create([
            'name' => 'News',
            'slug' => 'news',
            'order' => 70,
            'show_in' => 1,
        ]);

    }
}
