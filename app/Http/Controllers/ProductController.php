<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\LinkItem;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('id', 4)->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $categories = Category::active()->withTranslation($locale)->latest()->get();
        return view('products.index', compact('breadcrumbs', 'page', 'categories'));
    }

    public function show(Product $product)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('id', 4)->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));
        $breadcrumbs->addItem(new LinkItem($product->getTranslatedAttribute('name'), $product->url, LinkItem::STATUS_INACTIVE));

        $otherProducts = Product::where('id', '!=', $product->id)->active()->inRandomOrder()->withTranslation($locale)->take(4)->get();

        return view('products.show', compact('breadcrumbs', 'product', 'otherProducts'));
    }
}
