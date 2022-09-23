<?php

namespace App\View\Components;

use App\Helpers\Helper;
use App\Models\Page;
use Illuminate\View\Component;

class About extends Component
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
        $locale = app()->getLocale();
        $page = Page::where('id', 3)->withTranslation($locale)->firstOrFail();
        $siteTitle = Helper::setting('site.title');
        return view('components.about', compact('page', 'siteTitle'));
    }
}
