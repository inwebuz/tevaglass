<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompareController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $breadcrumbs->addItem(new LinkItem(__('main.compare_list'), route('compare.index'), LinkItem::STATUS_INACTIVE));

        $compare = app('compare');
        $compareItems = $compare->getContent()->sortBy('id');

        $compareList = [];
        $allAttributes = [];
        foreach($compareItems as $compareItem) {
            $product = $compareItem->associatedModel;
            $product->load(['attributes', 'attributeValues', 'translations']);
            $attributes = $product->attributes()->withTranslation($locale)->get();
            // $attributeValues = $product->attributes;

            foreach($attributes as $attribute) {
                $allAttributes[$attribute->id] = $attribute->getTranslatedAttribute('name');
            }

            $compareList[$compareItem->id] = [
                'product' => $product,
            ];
        }

        foreach ($compareList as $key => $value) {
            $product = $value['product'];
            $value['attributes'] = [];
            foreach($allAttributes as $attributeId => $attributeName) {
                $value['attributes'][$attributeId] = [];
                $productAttributeValues = $product->attributeValues()->withTranslation($locale)->get()->sortBy('name', SORT_NATURAL);
                foreach($productAttributeValues as $productAttributeValue) {
                    if ($productAttributeValue->attribute_id == $attributeId) {
                        $value['attributes'][$attributeId][] = $productAttributeValue->getTranslatedAttribute('name');
                    }
                }
            }
            $compareList[$key] = $value;
        }

        return view('compare', compact('breadcrumbs', 'allAttributes', 'compareList', 'compareItems'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required',
            'price' => 'required',
        ]);

        $data['price'] = (float)$data['price'];
        $data['quantity'] = 1;
        $data['associatedModel'] = Product::findOrFail($request->input('id'));

        // if (
        //     $data['associatedModel']->current_price != $data['price']
		// 	// || trim($data['associatedModel']->name) != trim($data['name'])
        // ) {
        //     abort(400);
        // }

        app('compare')->add($data);

        return response([
            'compare' => $this->getCompareInfo(app('compare')),
            'message' => __('main.product_added_to_compare'),
        ], 201);
    }

    public function delete($id)
    {
        app('compare')->remove($id);

        return response(array(
            'compare' => $this->getCompareInfo(app('compare')),
            'message' => __('main.product_removed_from_compare')
        ), 200);
    }

    private function getCompareInfo($compare)
    {
        $subtotal = $compare->getSubtotal();
        $total = $compare->getTotal();
        return [
            'quantity' => $compare->getTotalQuantity(),
            'subtotal' => $subtotal,
            'subtotalFormatted' => Helper::formatPrice($subtotal),
            'total' => $total,
            'totalFormatted' => Helper::formatPrice($total),
        ];
    }
}
