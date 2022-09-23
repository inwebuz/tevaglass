<?php

namespace App\Http\Controllers\Voyager;

use App\Models\Attribute;
use App\Models\ProductAttributesTemplate;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class VoyagerProductAttributesTemplateController extends VoyagerBaseController
{
    public function builderEdit(Request $request, ProductAttributesTemplate $productAttributesTemplate)
    {
        // Check permission
        $this->authorize('edit', $productAttributesTemplate);
        return Voyager::view('voyager::product_attributes_templates.builder', compact('productAttributesTemplate'));
    }

    public function builderUpdate(Request $request, ProductAttributesTemplate $productAttributesTemplate)
    {
        // Check permission
        $this->authorize('edit', $productAttributesTemplate);

        $data = $request->validate([
            'attributes' => 'required|array',
            'attributes.*.name' => 'required',
            'attributes.*.order' => 'required|integer',
        ]);
        $attributes = [];
        foreach ($data['attributes'] as $key => $value) {
            $attributes[] = [
                'id' => $key,
                'name' => $value['name'],
                'order' => (int)$value['order'],
            ];
        }
        $productAttributesTemplate->body = $attributes;
        $productAttributesTemplate->save();

        return redirect()->back()->with([
            'message'    => 'Атрибуты сохранены',
            'alert-type' => 'success',
        ]);
    }
}
