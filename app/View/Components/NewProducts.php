<?php

namespace App\View\Components;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class NewProducts extends Component
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
        $newProducts = Product::active()
            ->new()
            ->with(['categories' => function($query) use ($locale) {
                $query->withTranslation($locale);
            }])
            ->withTranslation($locale)
            ->latest()
            ->take(6)
            ->get();

        return view('components.new_products', compact('newProducts'));
    }
}
