<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $quantity = (int)$request->input('quantity', 30);
        if ($quantity > 120 || $quantity < 1) {
            $quantity = 30;
        }

        $locale = app()->getLocale();
        $stores = Store::active()->withTranslation($locale)->orderBy('order')->paginate($quantity)->appends($request->all());
        return StoreResource::collection($stores);
    }

    public function show(Request $request, Store $store)
    {
        // $locale = app()->getLocale();
        $store->load('translations');
        return new StoreResource($store);
    }
}
