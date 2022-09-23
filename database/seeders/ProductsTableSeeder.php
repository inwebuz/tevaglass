<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\Redirect;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $attributes = Attribute::with('attributeValues')->get()->keyBy('name');
        $categories = Category::all()->keyBy('id');

        // simple products
        Product::factory()->count(20)->create()->each(function($product){
            // categories
            $category = Category::inRandomOrder()->first();
            $product->categories()->sync([$category->id]);
        });

    }
}
