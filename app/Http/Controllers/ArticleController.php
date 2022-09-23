<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\LinkItem;
use Illuminate\Http\Request;
use App\Article;
use App\Models\Page;
use App\Helpers\Helper;

class ArticleController extends Controller
{
    /**
     * show all articles
     */
    public function index()
    {
        $breadcrumbs = new Breadcrumbs();

        $page = Page::find(4); // articles page
        if(!$page) {
            abort(404);
        }
        $page->load('translations');

        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));

        $articles = Article::active()->latest()->paginate(10);

        return view('articles', compact('breadcrumbs', 'page', 'articles'));
    }

    /**
     * show single article
     */
    public function view(Article $article)
    {
        $breadcrumbs = new Breadcrumbs();

        $page = Page::find(4); // articles page
        $page->load('translations');
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        $article = $article;
        $breadcrumbs->addItem(new LinkItem($article->getTranslatedAttribute('name'), $article->url, LinkItem::STATUS_INACTIVE));

        return view('article', compact('breadcrumbs', 'page', 'article'));
    }
}
