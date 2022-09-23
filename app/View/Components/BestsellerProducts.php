<?php

namespace App\View\Components;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class BestsellerProducts extends Component
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
        $bestsellerProducts = Product::active()
            ->bestsellers()
            ->with(['categories' => function($query) use ($locale) {
                $query->withTranslation($locale);
            }])
            ->withTranslation($locale)
            ->inRandomOrder()
            // ->latest()
            ->take(6)
            ->get();

        return view('components.bestseller_products', compact('bestsellerProducts'));
    }
}
