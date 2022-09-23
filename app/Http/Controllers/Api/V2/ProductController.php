<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Attribute;
use App\Models\Category;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttributeResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\StickerResource;
use App\Models\Product;
use App\Models\Search;
use App\Models\Sticker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $quantity = (int)$request->input('quantity', 30);
        if ($quantity > 120 || $quantity < 1) {
            $quantity = 30;
        }
        $categoryId = $request->input('category_id', null);
        // $brandId = $request->input('brand_id', null);
        $brands = $request->input('brands', []);
        if (!empty($brands) && !is_array($brands)) {
            $brands = [];
        }
        $attributes = $request->input('attributes', []);
        if (!empty($attributes) && !is_array($attributes)) {
            $attributes = [];
        }

        $search = Helper::escapeFullTextSearch($request->input('search', ''));

        $priceFrom = (float)$request->input('price_from', -1);
        $priceTo = (float)$request->input('price_to', -1);
        $isNew = (int)$request->input('is_new', -1);
        $isBestseller = (int)$request->input('is_bestseller', -1);
        $isPromotion = (int)$request->input('is_promotion', -1);

        $orderBy = $request->input('order_by', 'created_at');
        if (!in_array($orderBy, ['created_at', 'price', 'views', 'rating'])) {
            $orderBy = 'created_at';
        }
        $orderBy = 'products.' . $orderBy;
        $orderDirection = $request->input('order_direction', 'desc');
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }


        // create query
        if ($categoryId) {
            $category = Category::findOrFail($categoryId);
            $query = $category->products();
        } else {
            $query = Product::query();
        }

        // main requirements
        $query->active()
            ->withTranslation($locale)
            ->with([
                'stickers' => function($query) use ($locale) {
                    $query->active()->withTranslation($locale);
                },
                'categories' => function($query) use ($locale) {
                    $query->active()->withTranslation($locale);
                },
                'brand' => function($query) use ($locale) {
                    $query->withTranslation($locale);
                },
            ]);

        // brand
        // if ($brandId) {
        //     $query->where('products.brand_id', $brandId);
        // }

        // brands
        if ($brands) {
            $query->whereIn('products.brand_id', $brands);
        }

        // price
        if ($priceFrom >= 0) {
            $query->where('products.price', '>=', $priceFrom);
        }
        if ($priceTo >= 0) {
            $query->where('products.price', '<=', $priceTo);
        }

        // flags
        if ($isNew >= 0) {
            $query->where('products.is_new', $isNew);
        }
        if ($isBestseller >= 0) {
            $query->where('products.is_bestseller', $isBestseller);
        }
        if ($isPromotion >= 0) {
            $query->where('products.is_promotion', $isPromotion);
        }

        // attributes, attribute values
        if ($attributes) {
            foreach($attributes as $values) {
                $attributeValueIds = [];
                $values = array_map('intval', $values);
                $attributeValueIds = array_merge($attributeValueIds, $values);
                if ($attributeValueIds) {
                    $query->whereIn('products.id', function($q1) use ($attributeValueIds) {
                        $q1->select('products.id')->from('products')->whereIn('products.id', function($q2) use ($attributeValueIds) {
                            $q2->select('attribute_value_product.product_id')->from('attribute_value_product')->whereIn('attribute_value_product.attribute_value_id', $attributeValueIds);
                        });
                    });
                }
            }
        }

        // search
        if ($search && Str::length($search) >= 3) {
            $searchQuery = Search::selectRaw("*, MATCH(body) AGAINST('" . $search . "')")
                ->whereRaw("MATCH(body) AGAINST('" . $search . "' IN BOOLEAN MODE)")
                ->where('searchable_type', Product::class);
            $count = $searchQuery->count();
            if ($count == 0) {
                $searchQuery = Search::where('body', 'like', '%' . $search . '%')
                    ->where('searchable_type', Product::class);
            }
            $productIDs = $searchQuery->pluck('searchable_id')->toArray();
            if (!$productIDs) {
                $productIDs = [-1];
            }
            $query->whereIn('products.id', $productIDs)->orderByRaw("FIELD(products.id," . implode(',', $productIDs) . ")");
        }

        // sort order
        // $query->orderByRaw('products.in_stock = 0');
        $query->orderBy($orderBy, $orderDirection);

        // get products
        $products = $query->paginate($quantity)->appends($request->all());

        return ProductResource::collection($products);
    }

    public function show(Request $request, Product $product)
    {
        $locale = app()->getLocale();
        $product->increment('views');
        $product->load('translations');
        $product->load([
            'stickers' => function($query) use ($locale) {
                $query->active()->withTranslation($locale);
            },
            'categories' => function($query) use ($locale) {
                $query->active()->withTranslation($locale);
            },
            'brand' => function($query) use ($locale) {
                $query->withTranslation($locale);
            },
        ]);
        return new ProductResource($product);
    }

    public function attributes(Request $request, Product $product)
    {
        $locale = app()->getLocale();

        $attributeValueIds = DB::table('attribute_value_product')->where('attribute_value_product.product_id', $product->id)->pluck('attribute_value_product.attribute_value_id')->unique();

        $attributeIds = DB::table('attribute_values')
            ->leftJoin('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
            ->whereIn('attribute_values.id', $attributeValueIds->toArray())
            ->pluck('attributes.id')
            ->unique();

        $query = Attribute::whereIn('attributes.id', $attributeIds->toArray())
            ->withTranslation($locale)
            ->with(['attributeValues' => function ($q1) use ($locale, $attributeValueIds) {
                $q1->whereIn('attribute_values.id', $attributeValueIds->toArray())
                    ->withTranslation($locale);
            }]);
        $attributes = $query->get();
        return AttributeResource::collection($attributes);
    }

    public function stickers(Request $request, Product $product)
    {
        $locale = app()->getLocale();
        $stickers = $product->stickers()->active()->orderBy('stickers.order')->withTranslation($locale)->get();
        return StickerResource::collection($stickers);
    }

    public function categories(Request $request, Product $product)
    {
        $locale = app()->getLocale();
        $categories = $product->categories()->active()->withTranslation($locale)->get();
        return CategoryResource::collection($categories);
    }
}
