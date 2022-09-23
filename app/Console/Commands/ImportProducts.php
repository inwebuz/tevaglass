<?php

namespace App\Console\Commands;

use App\Models\Attribute;
use App\Models\Category;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\Redirect;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products {start=0} {limit=500}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = (int)$this->argument('start');
        $limit = (int)$this->argument('limit');
        $end = $start + $limit;

        $attributes = Attribute::with('attributeValues')->get()->keyBy('name');
        $categories = Category::all()->keyBy('id');

        // file
        $filePath = Storage::path('import/products.xlsx');
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($filePath);
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $key => $row) {
                // ignore title row
                if ($key == 1) {
                    continue;
                }
                if ($key < $start) {
                    continue;
                }
                if ($key > $end) {
                    break;
                }

                // upload product
                $cells = $row->getCells();

                $data = [];

                $data['id'] = isset($cells[0]) ? trim($cells[0]->getValue()) : null;
                $data['brand_id'] = isset($cells[1]) ? trim($cells[1]->getValue()) : null;
                $category_ids = isset($cells[2]) ? trim($cells[2]->getValue()) : null;
                $category_ids = explode(',', $category_ids);
                $data['name'] = isset($cells[3]) ? trim($cells[3]->getValue()) : '';
                $data['slug'] = Str::slug($data['name']);
                $data['sku'] = isset($cells[4]) ? trim($cells[4]->getValue()) : '';
                $data['price'] = isset($cells[6]) ? (float)trim($cells[6]->getValue()) : 0;
                $data['installment_price'] = isset($cells[5]) ? (float)trim($cells[5]->getValue()) : $data['price'];
                $data['sale_price'] = isset($cells[7]) ? (float)trim($cells[7]->getValue()) : 0;
                $data['in_stock'] = isset($cells[8]) ? (int)trim($cells[8]->getValue()) : 0;
                $productAttributes = isset($cells[10]) ? trim($cells[10]->getValue()) : '';
				$data['status'] = isset($cells[11]) ? (int)trim($cells[11]->getValue()) : 1;
                $oldURL = isset($cells[12]) && $cells[12] ? trim($cells[12]->getValue()) : '';
                $image_urls = isset($cells[13]) ? trim($cells[13]->getValue()) : '';
                $image_urls = explode(',', $image_urls);
                // $data['image'] = 'brands/00' . mt_rand(1, 6) . '.png';
                // $data['image'] = str_replace('https://radius.uz/wp-content/', '', $image_urls[0]);
                // $data['short_description'] = isset($cells[4]) ? trim($cells[4]->getValue()) : '';
                $data['description'] = isset($cells[14]) ? strip_tags(trim($cells[14]->getValue())) : '';
                $data['body'] = isset($cells[15]) ? trim($cells[15]->getValue()) : '';
                $data['order'] = isset($cells[17]) ? trim($cells[17]->getValue()) : 0;
                $data['seo_title'] = isset($cells[18]) ? trim($cells[18]->getValue()) : '';
                $data['meta_description'] = isset($cells[19]) ? trim($cells[19]->getValue()) : '';
                $data['meta_keywords'] = isset($cells[20]) ? trim($cells[20]->getValue()) : '';
				$data['is_bestseller'] = mt_rand(1, 50) == 1 ? 1 : 0;
				$data['is_new'] = mt_rand(1, 50) == 1 ? 1 : 0;
				$data['is_promotion'] = mt_rand(1, 50) == 1 ? 1 : 0;

                // check product
                $isNew = false;
                $product = Product::find($data['id']);
                if (!$product) {
                    $product = Product::create($data);
                    $isNew = true;
                }

                // sync categories
                $syncCategoryIDs = [];
                foreach ($category_ids as $category_id) {
                    $category = $categories[$category_id] ?? null;
                    if ($category) {
                        $syncCategoryIDs = array_merge($syncCategoryIDs, Category::parentIDs($category));
                    }
                }
                $product->categories()->sync($syncCategoryIDs);

                // sync attributes
                if ($productAttributes) {
                    $productAttributes = explode('|', $productAttributes);
                    foreach ($productAttributes as $value) {
                        $row = explode(':', $value);
                        if (empty($row[0]) || empty($row[1])) {
                            continue;
                        }
                        $row[0] = trim($row[0]);
                        $row[1] = trim($row[1]);
                        if ($row[0] == 'Бренд') {
                            continue;
                        }

                        if (empty($attributes[$row[0]])) {
                            $attributes[$row[0]] = Attribute::create([
                                'name' => $row[0],
                                'slug' => Str::slug($row[0]),
                                'used_for_filter' => 1,
                            ]);
                        }
                        $attribute = $attributes[$row[0]];
                        $attributeValue = $attribute->attributeValues->where('name', $row[1])->first();
                        if (!$attributeValue) {
                            $attributeValue = $attribute->attributeValues()->create([
                                'name' => $row[1],
                                'slug' => Str::slug($row[1]),
                                'used_for_filter' => 1,
                            ]);
                        }
                        $attribute->load('attributeValues');
                        $product->attributes()->syncWithoutDetaching([$attribute->id]);
                        $product->attributeValues()->syncWithoutDetaching([$attributeValue->id]);
                    }
                }

                // sync images
                if ($image_urls[0]) {
                    Helper::storeImageFromUrl($image_urls[0], $product, 'image', 'products', Product::$imgSizes);
                    array_shift($image_urls);
                    if (count($image_urls)) {
                        foreach ($image_urls as $value) {
                            if (!$value) {
                                continue;
                            }
                            Helper::storeImageFromUrl($value, $product, 'images', 'products', Product::$imgSizes, true);
                        }
                    }
                }

                // create redirect
                // $from = rtrim(str_replace(config('app.url'), '', $oldURL), '/');
                $from = rtrim(str_replace('https://radius.uz', '', $oldURL), '/');
                $to = str_replace(config('app.url'), '', $product->url);
                if ($isNew && $from != $to) {
                    Redirect::create([
                        'from' => $from,
                        'to' => $to,
                    ]);
                }
            }
            // ignore other sheets
            break;
        }
        $reader->close();
        return 0;
    }
}
