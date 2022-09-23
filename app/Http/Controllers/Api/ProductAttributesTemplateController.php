<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductAttributesTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductAttributesTemplateController extends ApiController
{
    public function index(Request $request)
    {
        //
    }

    public function show(ProductAttributesTemplate $productAttributesTemplate)
    {
        return $productAttributesTemplate;
    }
}
