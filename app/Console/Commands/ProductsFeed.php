<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Product;
use DOMAttr;
use DOMDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProductsFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:feed {operation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate product feed';

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
        $operation = $this->argument('operation');
        if (method_exists($this, $operation)) {
            return $this->$operation();
        }
        return 0;
    }

    private function hatchXml()
    {
        // variant 1
        // $dom = new DOMDocument();
		// $dom->encoding = 'utf-8';
		// $dom->xmlVersion = '1.0';
		// $dom->formatOutput = true;
        // $fileName = storage_path('app/public/xml/hatch-products-feed.xml');
        // $root = $dom->createElement('productfeed');
        // Product::active()->latest()->chunk(200, function($products) use ($dom, $root) {
        //     foreach ($products as $product) {
        //         $productNode = $dom->createElement('product');
        //         $nameNode = $dom->createElement('productname', $product->name);
		//         $productNode->appendChild($nameNode);
        //         $brandNode = $dom->createElement('brandname', $product->brand->name ?? '');
		//         $productNode->appendChild($brandNode);
        //         $mpnNode = $dom->createElement('MPN', $product->sku);
		//         $productNode->appendChild($mpnNode);
        //         $eanNode = $dom->createElement('EAN', $product->barcode);
		//         $productNode->appendChild($eanNode);
        //         $stockNode = $dom->createElement('stock', $product->getStock());
		//         $productNode->appendChild($stockNode);
        //         $priceNode = $dom->createElement('price', $product->current_price);
		//         $productNode->appendChild($priceNode);
        //         $categoryNode = $dom->createElement('category_name', $product->categories()->first()->name ?? '');
		//         $productNode->appendChild($categoryNode);
        //         $idNode = $dom->createElement('your_product_ID', $product->id);
		//         $productNode->appendChild($idNode);
        //         $imageNode = $dom->createElement('image_URL', $product->img);
		//         $productNode->appendChild($imageNode);
        //         $urlNode = $dom->createElement('product_URL', $product->url);
		//         $productNode->appendChild($urlNode);
        //         $promoNode = $dom->createElement('promo-text', $product->description);
		//         $productNode->appendChild($promoNode);
        //         $root->appendChild($productNode);
        //     }
        // });
        // $dom->appendChild($root);
    	// $dom->save($fileName);


        // variant 2
        $fileName = storage_path('app/public/xml/hatch-products-feed.xml');
        $fp = fopen($fileName, 'w');
        fwrite($fp, '<?xml version="1.0" encoding="utf-8"?><productfeed>');
        Product::active()->latest()->chunk(200, function($products) use ($fp) {
            foreach ($products as $product) {
                $category = $product->categories()->first();
                $text = '<product>';
                $text .= '<productname>' . htmlspecialchars($product->name, ENT_XML1, 'UTF-8') . '</productname>';
                $text .= '<brandname>' . ($product->brand ? htmlspecialchars($product->brand->name, ENT_XML1, 'UTF-8') : '') . '</brandname>';
                $text .= '<MPN>' . htmlspecialchars($product->sku, ENT_XML1, 'UTF-8') . '</MPN>';
                $text .= '<EAN>' . htmlspecialchars($product->barcode, ENT_XML1, 'UTF-8') . '</EAN>';
                $text .= '<stock>' . $product->getStock() . '</stock>';
                $text .= '<price>' . $product->current_price . '</price>';
                $text .= '<category_name>' . ($category ? htmlspecialchars($category->name, ENT_XML1, 'UTF-8') : '') . '</category_name>';
                $text .= '<your_product_ID>' . $product->id . '</your_product_ID>';
                $text .= '<image_URL>' . htmlspecialchars($product->img, ENT_XML1, 'UTF-8') . '</image_URL>';
                $text .= '<product_URL>' . htmlspecialchars($product->url, ENT_XML1, 'UTF-8') . '</product_URL>';
                $text .= '<promo-text>' . htmlspecialchars($product->description, ENT_XML1, 'UTF-8') . '</promo-text>';
                $text .= '</product>';
                fwrite($fp, $text);
            }
        });
        fwrite($fp, '</productfeed>');
        fclose($fp);
    }
}
