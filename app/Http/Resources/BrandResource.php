<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class BrandResource extends JsonResource
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
        $isSingleItemRequest = $request->routeIs('api.v2.brands.show');
        $seoReplacements = $isSingleItemRequest ? [
            'name' => $this->getTranslatedAttribute('name'),
            'products_quantity' => $this->products_quantity,
            'year' => date('Y'),
        ] : [];
        return [
            'id' => $this->id,
            'order' => $this->order,
            'name' => $this->getTranslatedAttribute('name'),
            'url' => $this->url,
            'img' => $this->image ? $appURL . $this->img : '',
            'small_img' => $this->image ? $appURL . $this->small_img : '',
            'description' => $this->getTranslatedAttribute('description'),
            'body' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('body')),
            'seo_title' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('seo_title') ?: Helper::seo('brand', 'seo_title', $seoReplacements)),
            'meta_description' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('meta_description') ?: Helper::seo('brand', 'meta_description', $seoReplacements)),
            'meta_keywords' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('meta_keywords') ?: Helper::seo('brand', 'meta_keywords', $seoReplacements)),
        ];
    }
}
