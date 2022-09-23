<?php

namespace App\View\Components;

use App\Models\Brand;
use App\Helpers\Helper;
use Illuminate\View\Component;

class SidebarCategories extends Component
{
    public $categoryId;
    public $activeCategoryId;
    public $brandId;

    public function __construct($categoryId = null, $activeCategoryId = null, $brandId = null)
    {
        $this->categoryId = $categoryId;
        $this->activeCategoryId = $activeCategoryId;
        $this->brandId = $brandId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $locale = app()->getLocale();
        $parentIDs = [];
        $allIDs = [];

        $brand = null;

        if ($this->categoryId) {
            $parentIDs[] = $this->categoryId;
        }
        if ($this->brandId) {
            $brand = Brand::where('id', $this->brandId)->withTranslation($locale)->firstOrFail();
            $allIDs = $brand->categories()->select('categories.id')->pluck('categories.id')->toArray();
        }

        $categories = Helper::categories('menu', 0, $parentIDs, $allIDs);

        return view('components.sidebar_categories', compact('categories', 'brand'));
    }
}
