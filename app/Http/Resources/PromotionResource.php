<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $appURL = config('app.url');
        $isSingleItemRequest = $request->routeIs('api.v2.promotions.show');
        $data = [
            'id' => $this->id,
            'name' => $this->getTranslatedAttribute('name'),
            'url' => $this->url,
            'img' => $this->image ? $appURL . $this->img : '',
            'medium_img' => $this->image ? $appURL . $this->medium_img : '',
            'description' => $this->getTranslatedAttribute('description'),
            'body' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('body')),
            'start_at' => $this->start_at->format('Y-m-d H:i:s'),
            'end_at' => $this->end_at->format('Y-m-d H:i:s'),
            'is_archived' => $this->is_archived,
            'seo_title' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('seo_title') ?: $this->getTranslatedAttribute('name')),
            'meta_description' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('meta_description')),
            'meta_keywords' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('meta_keywords')),
        ];
        return $data;
    }
}
