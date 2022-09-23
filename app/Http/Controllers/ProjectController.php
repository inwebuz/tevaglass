<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('id', 5)->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $projects = Project::active()->withTranslation($locale)->latest()->paginate(3);
        $links = $projects->links('partials.pagination');
        return view('projects.index', compact('page', 'breadcrumbs', 'projects', 'links'));
    }

    public function show(Request $request, Project $project, $slug)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $project->load('translations');

        // check slug
        if ($project->getTranslatedAttribute('slug') != $slug) {
            abort(404);
        }

        $page = Page::where('id', 5)->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));
        $breadcrumbs->addItem(new LinkItem($project->getTranslatedAttribute('name'), $project->url, LinkItem::STATUS_INACTIVE));

        $products = $project->products()->active()->withTranslation($locale)->get();

        return view('projects.show', compact('page', 'breadcrumbs', 'project', 'products'));
    }

}
