<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $appURL = config('app.url');
        $isSingleItemRequest = $request->routeIs('api.v2.products.show');
        $seoReplacements = $isSingleItemRequest ? [
            'name' => $this->getTranslatedAttribute('name'),
            'price' => Helper::formatPrice($this->current_price),
            'brand_name' => $this->brand ? $this->brand->getTranslatedAttribute('name') : '',
            'year' => date('Y'),
        ] : [];
        $data = [
            'id' => $this->id,
            'product_group_id' => $this->product_group_id,
            'name' => $this->getTranslatedAttribute('name'),
            'url' => $this->url,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'brand_id' => $this->brand_id,
            'img' => $this->image ? $appURL . $this->img : '',
            'micro_img' => $this->image ? $appURL . $this->micro_img : '',
            'small_img' => $this->image ? $appURL . $this->small_img : '',
            'medium_img' => $this->image ? $appURL . $this->medium_img : '',
            'gallery' => [],
            'current_price' => $this->current_price,
            'current_price_formatted' => Helper::formatPrice($this->current_price),
            'old_price' => $this->old_price,
            'old_price_formatted' => Helper::formatPrice($this->old_price),
            'installment_prices' => $this->installmentPrices(),
            // 'min_price_per_month' => $this->current_min_price_per_month,
            // 'min_price_per_month_formatted' => Helper::formatPrice($this->current_min_price_per_month),
            // 'min_price_per_month_duration' => $this->min_price_per_month_duration,
            'discount' => $this->discount_percent > 0 ? ('-' . $this->discount_percent . '%') : '',
            'in_stock' => $this->getStock(),
            'rating' => floatval($this->rating),
            'rating_count' => intval($this->active_reviews_count),
            'description' => $this->getTranslatedAttribute('description'),
            'body' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('body')),
            'views' => $this->views,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'stickers' => StickerResource::collection($this->whenLoaded('stickers')),
            // 'brand' => new BrandResource($this->whenLoaded('brand')),
            'brand_name' => $this->brand ? $this->brand->getTranslatedAttribute('name') : '',
            'seo_title' => $this->when($isSingleItemRequest, $this->seo_title ?: Helper::seo('product', 'seo_title', $seoReplacements)),
            'meta_description' => $this->when($isSingleItemRequest, $this->meta_description ?: Helper::seo('product', 'meta_description', $seoReplacements)),
            'meta_keywords' => $this->when($isSingleItemRequest, $this->meta_keywords ?: Helper::seo('product', 'meta_keywords', $seoReplacements)),
        ];

        if ($this->image) {
            $data['gallery'][] = [
                'original' => $appURL . $this->img,
                'micro' => $appURL . $this->micro_img,
                'small' => $appURL . $this->small_img,
                'medium' => $appURL . $this->medium_img,
            ];
        }

        foreach ($this->imgs as $key => $value) {
            $data['gallery'][] = [
                'original' => $appURL . $value,
                'micro' => $appURL . $this->micro_imgs[$key],
                'small' => $appURL . $this->small_imgs[$key],
                'medium' => $appURL . $this->medium_imgs[$key],
            ];
        }
        return $data;
    }
}
