<?php

namespace App\View\Components;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class DiscountedProducts extends Component
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
        $discountedProductsQuery = Product::active()
            ->discounted()
            ->with(['categories' => function($query) use ($locale) {
                $query->withTranslation($locale);
            }])
            ->withTranslation($locale)
            ->latest();
        $discountedProducts = $discountedProductsQuery->take(6)->get();
        return view('components.discounted_products', compact('discountedProducts'));
    }
}
