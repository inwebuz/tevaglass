<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index(Request $request)
    {
        $quantity = (int)$request->input('quantity', 30);
        if ($quantity > 120 || $quantity < 1) {
            $quantity = 30;
        }

        $locale = app()->getLocale();
        $products = Product::active()->withTranslation($locale)->orderBy('order')->paginate($quantity)->appends($request->all());
        return ProductResource::collection($products);
    }

    public function show(Request $request, Product $product)
    {
        $locale = app()->getLocale();
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

    public function bulkUpdate(Request $request)
    {
        $this->authorize('create', Product::class);

        $result = [];
        $data = $request->validate([
            'data' => 'required|array',
        ]);
        $allowedFields = ['name', 'external_id', 'sku', 'barcode', 'description', 'body', 'status', 'price', 'sale_price', 'installment_price_3', 'installment_price_6', 'installment_price_12', 'in_stock'];
        foreach ($data['data'] as $value) {
            $rowResult = [
                'success' => false,
                'message' => '',
            ];
            $id = $value['id'] ?? '';
            $product = null;
            if ($id) {
                $product = Product::find($id);
            }
            if (!$product) {
                $rowResult['message'] = __('main.product_not_found');
            }
            $updateData = array_filter($value, function($key) use ($allowedFields) {
                return in_array($key, $allowedFields);
            }, ARRAY_FILTER_USE_KEY);

            // check update data
            if (isset($updateData['name'])) {
                $updateData['name'] = Str::limit($updateData['name'], 191, '');
                $updateData['slug'] = Str::slug($updateData['name']);
            }
            if (isset($updateData['external_id'])) {
                $updateData['external_id'] = Str::limit($updateData['external_id'], 191, '');
            }
            if (isset($updateData['sku'])) {
                $updateData['sku'] = Str::limit($updateData['sku'], 191, '');
            }
            if (isset($updateData['barcode'])) {
                $updateData['barcode'] = Str::limit($updateData['barcode'], 191, '');
            }
            if (isset($updateData['description'])) {
                $updateData['description'] = Str::limit($updateData['description'], 50000, '');
            }
            if (isset($updateData['body'])) {
                $updateData['body'] = Str::limit($updateData['body'], 500000, '');
            }
            if (isset($updateData['status']) && !in_array($updateData['status'], [Product::STATUS_ACTIVE, Product::STATUS_INACTIVE])) {
                $updateData['status'] = Product::STATUS_INACTIVE;
            }
            if (isset($updateData['price'])) {
                $updateData['price'] = floatval($updateData['price']);
            }
            if (isset($updateData['sale_price'])) {
                $updateData['sale_price'] = floatval($updateData['sale_price']);
            }
            if (isset($updateData['installment_price_3'])) {
                $updateData['installment_price_3'] = floatval($updateData['installment_price_3']);
            }
            if (isset($updateData['installment_price_6'])) {
                $updateData['installment_price_6'] = floatval($updateData['installment_price_6']);
            }
            if (isset($updateData['installment_price_12'])) {
                $updateData['installment_price_12'] = floatval($updateData['installment_price_12']);
            }
            if (isset($updateData['in_stock'])) {
                $updateData['in_stock'] = intval($updateData['in_stock']);
            }

            // update
            $product->update($updateData);
            $rowResult['success'] = true;
            $rowResult['message'] = 'OK';
            $result[] = $rowResult;
        }
        return response()->json([
            'data' => $result,
        ]);
    }
}
