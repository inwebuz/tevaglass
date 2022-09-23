<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\LinkItem;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Page;
use App\Models\Review;

class PageController extends Controller
{
    /**
     * show single page
     */
    public function index(Page $page, $slug)
    {
        $locale = app()->getLocale();
        // $page = Page::where('slug', $slug)->withTranslation($locale)->firstOrFail();
        Helper::checkModelActive($page);
        $breadcrumbs = new Breadcrumbs();

        $page->increment('views');
        $page->load('translations');

        if ($page->parent_id) {
            $parentPage = $page->parent;
            $parentPage->load('translations');
            $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
        }
        $siblingPages = Helper::siblingPages($page);
        if (!$page->parent_id) {
            $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        }

        return view('page.index', compact('breadcrumbs', 'page', 'siblingPages'));
    }

    public function about()
    {
        $locale = app()->getLocale();
        // $page = Page::where('slug', $slug)->withTranslation($locale)->firstOrFail();
        $page = Page::where('id', 3)->withTranslation($locale)->firstOrFail();
        Helper::checkModelActive($page);
        $breadcrumbs = new Breadcrumbs();

        $page->increment('views');
        $page->load('translations');
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        return view('page.about', compact('breadcrumbs', 'page'));
    }

    public function print(Page $page)
    {
        $page->load('translations');
        return view('page.print', compact('page'));
    }

    public function guestbook()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('id', 20)->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $reviews = Review::active()->where('reviewable_type', Page::class)->where('reviewable_id', 1)->paginate(20);
        $links = $reviews->links();
        return view('page.guestbook', compact('page', 'breadcrumbs', 'reviews', 'links'));
    }
}
