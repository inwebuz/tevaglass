<?php

namespace App\Http\Controllers\Api;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributesController extends ApiController
{
    public function index(Request $request)
    {
        $query = Attribute::query();
        $search = $request->input('search', '');
        if (Str::length($search) >= 3) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }
        return $query->get();
    }

    public function attributeValues(Attribute $attribute)
    {
        return $attribute->attributeValues;
    }

    public function show(Attribute $attribute)
    {
        return $attribute;
    }
}
