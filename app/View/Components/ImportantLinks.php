<?php

namespace App\View\Components;

use App\Models\Page;
use Illuminate\View\Component;

class ImportantLinks extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $pages = [];
        $pages1 = Page::where('slug', 'about')->firstOrFail();
        $pages1->loadTranslations();
        $pages2 = Page::where('slug', 'news')->firstOrFail();
        $pages2->loadTranslations();
        $pages[] = $pages1;
        $pages[] = $pages2;
        return view('components.important-links', compact('pages'));
    }
}
