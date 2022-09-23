<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        Menu::firstOrCreate([
            'name' => 'admin',
        ]);
        Menu::firstOrCreate([
            'name' => 'footer-1',
        ]);
        Menu::firstOrCreate([
            'name' => 'footer-2',
        ]);
        Menu::firstOrCreate([
            'name' => 'footer-3',
        ]);
    }
}
