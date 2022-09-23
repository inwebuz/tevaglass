<?php

namespace App\Http\Controllers\Api;

use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValuesController extends ApiController
{
    public function index()
    {
        return AttributeValue::all();
    }

    public function show(AttributeValue $attributeValue)
    {
        return $attributeValue;
    }
}
