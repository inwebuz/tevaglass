<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Promotion;
use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public $types = ['active', 'archived'];

    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $quantity = (int)$request->input('quantity', 30);
        if ($quantity > 120 || $quantity < 1) {
            $quantity = 30;
        }
        $type = $request->input('type', '');
        $now = now();

        $query = Promotion::active()->withTranslation($locale);
        if (in_array($type, $this->types)) {
            switch ($type) {
                case 'active':
                    $query->where('start_at', '<=', $now)->where('end_at', '>=', $now);
                    break;
                case 'archived':
                    $query->where('end_at', '<=', $now);
                    break;
            }
        }

        $promotions = $query->latest()->paginate($quantity)->appends($request->all());
        return PromotionResource::collection($promotions);
    }

    public function show(Request $request, Promotion $promotion)
    {
        // $locale = app()->getLocale();
        $promotion->load('translations');
        return new PromotionResource($promotion);
    }
}
