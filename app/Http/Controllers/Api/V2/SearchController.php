<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttributeResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'search' => 'required|string|min:3',
            'type' => 'nullable|in:categories,brands,products',
        ]);
        $locale = app()->getLocale();
        $type = !empty($data['type']) ? $data['type'] : 'products';

        $quantity = (int)$request->input('quantity', 30);
        if ($quantity > 120 || $quantity < 1) {
            $quantity = 30;
        }

        $search = Helper::escapeFullTextSearch($request->input('search', ''));

        $searchQuery = Search::selectRaw("*, MATCH(body) AGAINST('" . $search . "')")
            ->whereRaw("MATCH(body) AGAINST('" . $search . "' IN BOOLEAN MODE)")
            ->with(['searchable' => function($q1) use ($locale) {
                $q1->withTranslation($locale);
            }]);
        $count = $searchQuery->count();
        if ($count == 0) {
            $searchQuery = Search::where('body', 'like', '%' . $search . '%')
                ->with(['searchable' => function($q1) use ($locale) {
                    $q1->withTranslation($locale);
                }]);
        }

        switch ($type) {
            case 'categories':
                $categories = collect();
                $queryClone = clone $searchQuery;
                $queryClone->where('searchable_type', Category::class);
                $categoryIDs  = $queryClone->take(3)->get()->pluck('searchable_id')->toArray();
                if ($categoryIDs) {
                    $categories = Category::active()->withTranslation($locale)->whereIn('id', $categoryIDs)->orderByRaw("FIELD(id," . implode(',', $categoryIDs) . ")")->paginate($quantity)->appends($request->all());
                }
                return CategoryResource::collection($categories);

            case 'brands':
                $brands = collect();
                $queryClone = clone $searchQuery;
                $queryClone->where('searchable_type', Brand::class);
                $brandIDs  = $queryClone->take(3)->get()->pluck('searchable_id')->toArray();
                if ($brandIDs) {
                    $brands = Brand::active()->withTranslation($locale)->whereIn('id', $brandIDs)->orderByRaw("FIELD(id," . implode(',', $brandIDs) . ")")->paginate($quantity)->appends($request->all());
                }
                return BrandResource::collection($brands);

            default:
                $products = collect();
                $queryClone = clone $searchQuery;
                $queryClone->where('searchable_type', Product::class);
                $productIDs  = $queryClone->take(6)->get()->pluck('searchable_id')->toArray();
                if ($productIDs) {
                    $products = Product::active()->withTranslation($locale)->whereIn('id', $productIDs)->orderByRaw("FIELD(id," . implode(',', $productIDs) . ")")->paginate($quantity)->appends($request->all());
                }
                return ProductResource::collection($products);
        }
    }
}
