<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Models\Page;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('slug', 'shops')->active()->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $shops = Shop::active()->withTranslation($locale)->get();
        return view('shop.index', compact('page', 'breadcrumbs', 'shops'));
    }

    public function show(Shop $shop)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $shop->load('translations');
        $page = Page::where('slug', 'shops')->active()->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));
        $products = $shop->products()->active()->withTranslation($locale)->paginate(24);
        $links = $products->links();
        $breadcrumbs->addItem(new LinkItem($shop->getTranslatedAttribute('name'), $shop->url, LinkItem::STATUS_INACTIVE));
        return view('shop.show', compact('page', 'breadcrumbs', 'shop', 'products', 'links'));
    }
}
