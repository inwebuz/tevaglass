<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Models\Page;
use App\Models\Publication;
use Illuminate\Support\Carbon;
use Exception;
use IntlDateFormatter;
use Spatie\SchemaOrg\AggregateRating;
use Spatie\SchemaOrg\Schema;

class PublicationController extends Controller
{
    public function index()
    {
        //
    }

    public function news()
    {
        $locale = app()->getLocale();
        $page = Page::where('slug', 'news')->active()->withTranslation($locale)->firstOrFail();

        $paginationPage = request('page', 1);
        if (!is_int($paginationPage)) {
            $paginationPage = 1;
        }

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        // $siblingPages = Helper::siblingPages($page);

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()->news()->latest()->withTranslation($locale);

        // $today = Carbon::now();
        // $end = request('end', $today->format('d.m.Y'));
        // $start = request('start', $today->subMonths(3)->format('d.m.Y'));
        // try {
        //     $periodStart = Carbon::createFromFormat('d.m.Y', $start);
        //     $periodEnd = Carbon::createFromFormat('d.m.Y', $end);
        //     if($periodStart > $periodEnd) {
        //         $tempPeriod = $periodStart;
        //         $periodStart = $periodEnd;
        //         $periodEnd = $tempPeriod;
        //     }
        //     $query->where('created_at', '>=', $periodStart->startOfDay()->format('Y-m-d H:i:s'));
        //     $query->where('created_at', '<=', $periodEnd->endOfDay()->format('Y-m-d H:i:s'));
        // } catch (Exception $e) {
        //     abort(404);
        // }

        $publications = $query->paginate(6);

        //$links = $publications->appends(['start' => Helper::formatDate($periodStart), 'end' => Helper::formatDate($periodEnd)])->links('partials.pagination');
        $links = $publications->links('partials.pagination');

        // return view('publications.news', compact('breadcrumbs', 'page', 'paginationPage', 'publications', 'links'));
        return view('publications.publications', compact('breadcrumbs', 'page', 'paginationPage', 'publications', 'links'));
    }

    public function articles()
    {
        $locale = app()->getLocale();
        $page = Page::findOrFail(18);

        $paginationPage = request('page', 1);
        if (!is_int($paginationPage)) {
            $paginationPage = 1;
        }

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        // $siblingPages = Helper::siblingPages($page);

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()
            ->articles()
            ->latest()
            ->withTranslation($locale);

        $publications = $query->paginate(12);

        //$links = $publications->appends(['start' => Helper::formatDate($periodStart), 'end' => Helper::formatDate($periodEnd)])->links('partials.pagination');
        $links = $publications->links('partials.pagination');

        return view('publications.publications', compact('breadcrumbs', 'page', 'paginationPage', 'publications', 'links'));
    }

    public function videos()
    {
        $locale = app()->getLocale();
        $page = Page::findOrFail(12);

        $paginationPage = request('page', 1);
        if (!is_int($paginationPage)) {
            $paginationPage = 1;
        }

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        // $siblingPages = Helper::siblingPages($page);

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()
            ->videos()
            ->latest()
            ->withTranslation($locale);

        $publications = $query->paginate(8);

        //$links = $publications->appends(['start' => Helper::formatDate($periodStart), 'end' => Helper::formatDate($periodEnd)])->links();
        $links = $publications->links('partials.pagination');

        return view('publications.publications', compact('breadcrumbs', 'page', 'paginationPage', 'publications', 'links'));
    }

    public function promotions()
    {
        $locale = app()->getLocale();
        $page = Page::findOrFail(4);

        $paginationPage = request('page', 1);
        if (!is_int($paginationPage)) {
            $paginationPage = 1;
        }

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        // $siblingPages = Helper::siblingPages($page);

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()->promotions()->latest()->withTranslation($locale);

        $publications = $query->paginate(12);

        //$links = $publications->appends(['start' => Helper::formatDate($periodStart), 'end' => Helper::formatDate($periodEnd)])->links('partials.pagination');
        $links = $publications->links('partials.pagination');

        return view('publications.publications', compact('breadcrumbs', 'page', 'paginationPage', 'publications', 'links'));
    }

    public function events()
    {
        $locale = app()->getLocale();
        $page = Page::where('slug', 'events')->active()->withTranslation($locale)->firstOrFail();

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        $siblingPages = Helper::siblingPages($page);

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()->events()->latest()->withTranslation($locale);

        $publications = $query->paginate(12);

        $links = $publications->links('partials.pagination');

        return view('publications.publications', compact('breadcrumbs', 'page', 'publications', 'links', 'siblingPages'));
    }

    public function competitions()
    {
        $locale = app()->getLocale();
        $page = Page::where('slug', 'competitions')->active()->withTranslation($locale)->firstOrFail();

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        $siblingPages = Helper::siblingPages($page);

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()->competitions()->latest()->withTranslation($locale);

        $publications = $query->paginate(12);

        $links = $publications->links('partials.pagination');

        return view('publications.publications', compact('breadcrumbs', 'page', 'publications', 'links', 'siblingPages'));
    }

    public function projects()
    {
        $locale = app()->getLocale();
        $page = Page::where('slug', 'projects')->active()->withTranslation($locale)->firstOrFail();

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        $siblingPages = Helper::siblingPages($page);


        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()->projects()->latest()->withTranslation($locale);

        $publications = $query->paginate(12);

        $links = $publications->links('partials.pagination');

        return view('publications.publications', compact('breadcrumbs', 'page', 'publications', 'links', 'siblingPages'));
    }

    public function ads()
    {
        $locale = app()->getLocale();
        $page = Page::where('slug', 'ads')->active()->withTranslation($locale)->firstOrFail();

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        $siblingPages = Helper::siblingPages($page);

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()->ads()->latest()->withTranslation($locale);

        $publications = $query->paginate(12);

        $links = $publications->links('partials.pagination');

        return view('publications.publications', compact('breadcrumbs', 'page', 'publications', 'links', 'siblingPages'));
    }

    public function massMedia()
    {
        $locale = app()->getLocale();
        $page = Page::where('slug', 'mass-media')->active()->withTranslation($locale)->firstOrFail();

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        $siblingPages = Helper::siblingPages($page);

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()->massMedia()->latest()->withTranslation($locale);

        $publications = $query->paginate(12);

        $links = $publications->links('partials.pagination');

        return view('publications.publications', compact('breadcrumbs', 'page', 'publications', 'links', 'siblingPages'));
    }

    public function usefulLInks()
    {
        $locale = app()->getLocale();
        $page = Page::where('slug', 'useful-links')->active()->withTranslation($locale)->firstOrFail();

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        $siblingPages = Helper::siblingPages($page);

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()->usefulLInks()->latest()->withTranslation($locale);

        $publications = $query->paginate(12);

        $links = $publications->links('partials.pagination');

        return view('publications.publications', compact('breadcrumbs', 'page', 'publications', 'links', 'siblingPages'));
    }

    public function faq()
    {
        $locale = app()->getLocale();
        $page = Page::where('slug', 'faq')->active()->withTranslation($locale)->firstOrFail();

        $breadcrumbs = new Breadcrumbs();

        if ($page->parent_id) {
            $parentPage = $page->parent;
            if ($parentPage) {
                $parentPage->load('translations');
                $breadcrumbs->addItem(new LinkItem($parentPage->getTranslatedAttribute('name'), $parentPage->url));
            }
        }

        $siblingPages = Helper::siblingPages($page);

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $query = Publication::active()->faq()->latest()->withTranslation($locale);

        $publications = $query->get();

        return view('publications.faq', compact('breadcrumbs', 'page', 'publications', 'siblingPages'));
    }

    public function show(Publication $publication)
    {
        $locale = app()->getLocale();
        Helper::checkModelActive($publication);

        $breadcrumbs = new Breadcrumbs();
        $publication->load('translations');

        $page = $publication->typePage();
        if ($page) {
            $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));
        }

        $publication->increment('views');

        /* $reviewQuery = $publication->reviews()->active();
        $reviews = $reviewQuery->latest()->take(20)->get();
        $reviewsCount = $reviewQuery->count();
        $reviewsAvg = round($reviewQuery->avg('rating'), 1);

        // SEO templates
        $publication = Helper::seoTemplate($publication, 'publications', ['name' => $publication->name]);

        $microdata = Schema::product();
        $microdata->name($publication->name);
        $aggregateRating = new AggregateRating();
        $aggregateRating->worstRating(1)->bestRating(5)->ratingCount($reviewsCount)->ratingValue($reviewsAvg);
        $microdata->aggregateRating($aggregateRating);
        $microdata = $microdata->toScript(); */

        $breadcrumbs->addItem(new LinkItem($publication->getTranslatedAttribute('name'), $publication->url, LinkItem::STATUS_INACTIVE));

        // return view('publications.show', compact('breadcrumbs', 'publication', 'page', 'reviews', 'microdata'));
        return view('publications.show', compact('breadcrumbs', 'publication', 'page'));
    }

    public function print(Publication $publication)
    {
        $publication->load('translations');
        return view('publications.print', compact('publication'));
    }

    public function incrementViews(Publication $publication)
    {
        $publication->increment('views');
        return '';
    }
}
