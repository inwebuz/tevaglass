<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        return config('voyager.multilingual.locales');
    }

    public function main(Request $request)
    {
        return config('voyager.multilingual.default');
    }
}
