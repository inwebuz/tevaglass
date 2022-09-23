<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * show products per page values
     */
    public $quantityPerPage = [32, 64, 128];
    public $sorts = ['created_at-desc', 'price-asc', 'price-desc'];

    public function index()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('slug', 'brands')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $brands = Brand::active()->withTranslation($locale)->get();
        return view('brands.index', compact('page', 'breadcrumbs', 'brands'));
    }

    public function show(Request $request, Brand $brand, $slug)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $brand->load('translations');

        // check slug
        if ($brand->getTranslatedAttribute('slug') != $slug) {
            abort(404);
        }

        $page = Page::where('slug', 'brands')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // $currentRegion = Helper::getCurrentRegion();
        // $warehouseIDs = $currentRegion->warehouses->pluck('id')->toArray();

        // quantity per page
        $quantityPerPage = $this->quantityPerPage;
        $quantity = $request->input('quantity', $this->quantityPerPage[0]);
        if (!in_array($quantity, $this->quantityPerPage)) {
            $quantity = $this->quantityPerPage[0];
        }

        // sort - order
        $sorts = $this->sorts;
        $sortCurrent = $request->input('sort', '');
        if (empty($sortCurrent) || !in_array($sortCurrent, $sorts)) {
            $sortCurrent = $sorts[0];
        }
        $sortRaw = explode('-', $sortCurrent);
        $sort = $sortRaw[0];
        $order = $sortRaw[1];

        $query = $brand->products()
            // ->orderBy('products.' . $sort, $order)
            ->active()
            ->with(['categories' => function($query) use ($locale) {
                $query->withTranslation($locale);
            }])
            ->withTranslation($locale)
            ->orderBy('products.created_at');

        $productAllQuantity = $query->count();

        // get query products paginate
        $products = $query->paginate($quantity);
        $links = $products->links('partials.pagination');

        $breadcrumbs->addItem(new LinkItem($brand->getTranslatedAttribute('name'), $brand->url, LinkItem::STATUS_INACTIVE));

        return view('brands.show', compact('page', 'breadcrumbs', 'products', 'productAllQuantity', 'brand', 'links', 'quantity', 'quantityPerPage', 'sorts', 'sortCurrent'));
    }

}
