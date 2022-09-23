<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Helpers\Breadcrumbs;
use App\Helpers\LinkItem;
use App\Models\Page;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // $locale = app()->getLocale();
        // $breadcrumbs = new Breadcrumbs();
        // $page = Page::where('slug', 'categories')->firstOrFail();
        // $page->load('translations');
        // $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        // $categories = Category::active()->whereNull('parent_id')->withTranslation($locale)->get();
        // return view('categories.index', compact('page', 'breadcrumbs', 'categories'));
    }

    public function show(Request $request, Category $category)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('id', 4)->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // get query products paginate
        $products = $category->products()->paginate(2);
        $links = $products->links('partials.pagination');

        $breadcrumbs->addItem(new LinkItem($category->getTranslatedAttribute('name'), $category->url, LinkItem::STATUS_INACTIVE));

        return view('categories.show', compact('breadcrumbs', 'products', 'links', 'category'));
    }

}
