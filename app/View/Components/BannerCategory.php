<?php

namespace App\View\Components;

use App\Models\Banner;
use App\Helpers\Helper;
use Illuminate\View\Component;

class BannerCategory extends Component
{
    public $type;
    public $categoryId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $categoryId)
    {
        $this->type = $type;
        $this->categoryId = $categoryId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $locale = app()->getLocale();
        $banners = Banner::query()
            ->where('category_id', $this->categoryId)
            ->where('type', $this->type)
            ->active()
            ->withTranslation($locale)
            ->orderBy('order')
            ->latest()
            ->take(10)
            ->get();
        return view('components.banner_category', compact('banners'));
    }
}
