<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class CategoryResource extends JsonResource
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
        $isSingleItemRequest = $request->routeIs('api.v2.categories.show');
        $seoReplacements = $isSingleItemRequest ? [
            'name' => $this->getTranslatedAttribute('name'),
            'products_quantity' => $this->products_quantity,
            'min_price' => Helper::formatPrice($this->min_price),
            'max_price' => Helper::formatPrice($this->max_price),
            'year' => date('Y'),
        ] : [];
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'name' => $this->getTranslatedAttribute('name'),
            'full_name' => $this->full_name,
            'hierarchy_name' => $this->hierarchy_name,
            'url' => $this->url,
            'img' => $this->image ? $appURL . $this->img : '',
            'small_img' => $this->image ? $appURL . $this->small_img : '',
            'description' => $this->getTranslatedAttribute('description'),
            'body' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('body')),
            'children' => CategoryResource::collection($this->whenLoaded('children')),
            'seo_title' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('seo_title') ?: Helper::seo('category', 'seo_title', $seoReplacements)),
            'meta_description' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('meta_description') ?: Helper::seo('category', 'meta_description', $seoReplacements)),
            'meta_keywords' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('meta_keywords') ?: Helper::seo('category', 'meta_keywords', $seoReplacements)),
        ];
    }
}
