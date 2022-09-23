<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class RandomProducts extends Component
{
    public $products;
    public $showHeader;

    public function __construct($products = null, $showHeader = false)
    {
        $this->products = $products;
        $this->showHeader = $showHeader;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $locale = app()->getLocale();
        if (!$this->products) {
            $this->products = Product::active()->withTranslation($locale)->inRandomOrder()->take(2)->get();
        }

        return view('components.random_products');
    }
}
