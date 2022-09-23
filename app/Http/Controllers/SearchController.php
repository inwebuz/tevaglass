<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Page;
use App\Models\Product;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.nav.search'), route('search'), LinkItem::STATUS_INACTIVE));

        $q = Helper::escapeFullTextSearch($request->input('q', ''));

        $isJson = $request->input('json', '');

        $searches = collect([]);

        if ($q && Str::length($q) >= 3) {

            $query = Search::selectRaw("*, MATCH(body) AGAINST('" . $q . "')")
                ->whereRaw("MATCH(body) AGAINST('" . $q . "' IN BOOLEAN MODE)")
                ->whereHasMorph(
                    'searchable',
                    [Product::class, Category::class, Brand::class],
                    function ($q1) {
                        $q1->active();
                    }
                )
                ->with(['searchable' => function($q1) use ($locale) {
                    $q1->withTranslation($locale);
                }]);
            $count = $query->count();
            if ($count == 0) {
                $query = Search::where('body', 'like', '%' . $q . '%')
                    ->whereHasMorph(
                        'searchable',
                        [Product::class, Category::class, Brand::class],
                        function ($q1) {
                            $q1->active();
                        }
                    )
                    ->with(['searchable' => function($q1) use ($locale) {
                        $q1->withTranslation($locale);
                    }]);
            }


            if ($isJson) {
                // products
                $products = collect();
                $queryClone = clone $query;
                $queryClone->where('searchable_type', Product::class);
                $productIDs  = $queryClone->take(10)->get()->pluck('searchable_id')->toArray();
                if ($productIDs) {
                    $products = Product::active()->withTranslation($locale)->whereIn('id', $productIDs)->orderByRaw("FIELD(id," . implode(',', $productIDs) . ")")->get();
                }

                // categories
                $categories = collect();
                $queryClone = clone $query;
                $queryClone->where('searchable_type', Category::class);
                $categoryIDs  = $queryClone->take(10)->get()->pluck('searchable_id')->toArray();
                if ($categoryIDs) {
                    $categories = Category::active()->withTranslation($locale)->whereIn('id', $categoryIDs)->orderByRaw("FIELD(id," . implode(',', $categoryIDs) . ")")->get();
                }

                // brands
                $brands = collect();
                $queryClone = clone $query;
                $queryClone->where('searchable_type', Brand::class);
                $brandIDs  = $queryClone->take(10)->get()->pluck('searchable_id')->toArray();
                if ($brandIDs) {
                    $brands = Brand::active()->withTranslation($locale)->whereIn('id', $brandIDs)->orderByRaw("FIELD(id," . implode(',', $brandIDs) . ")")->get();
                }
            } else {
                // only products
                $query->where('searchable_type', Product::class);

                // get searches
                $searches = $query->paginate(30);
            }
        }

        if ($isJson) {
            return [
                'q' => $q,
                'products' => ProductResource::collection($products ?? collect()),
                'categories' => CategoryResource::collection($categories ?? collect()),
                'brands' => BrandResource::collection($brands ?? collect()),
            ];
        }

        $links = !$searches->isEmpty() ? $searches->appends(['q' => $q])->links('partials.pagination') : '';

        return view('search', compact('breadcrumbs', 'searches', 'links', 'q'));
    }

    public function ajax(Request $request)
    {
        $results = [];
        $q = $request->input('q', '');
        $searches = $this->getSearches($q, 50);
        foreach ($searches as $item) {
            $results[] = [
                'name' => $item->searchable->getTranslatedAttribute('name') ?? $item->searchable->getTranslatedAttribute('full_name'),
                'url' => $item->searchable->url,
            ];
        }

        return $results;
    }

    private function getSearches($q, $quantity = 0)
    {
        $locale = app()->getLocale();
        $searches = collect([]);
        if ($quantity == 0) {
            $quantity = $this->perPage;
        }

        if ($q && Str::length($q) >= 3) {

            $searches = Search::where('body', 'like', '%' . $q . '%')
                ->with(['searchable' => function($q1) use ($locale) {
                    $q1->withTranslation($locale);
                }])
                ->paginate($quantity);

            if ($searches->isEmpty()) {
                $qArray = explode(' ', $q);
                if (count($qArray) > 0) {
                    $searches = Search::where(function ($query) use ($qArray) {
                        foreach ($qArray as $qWord) {
                            if (mb_strlen($qWord) > 2) {
                                $query->orWhere('body', 'like', '%' . $qWord . '%');
                            }
                        }
                    })
                        ->with(['searchable' => function($q1) use ($locale) {
                            $q1->withTranslation($locale);
                        }])
                        ->paginate($quantity);
                }
            }
        }

        return $searches;
    }
}
