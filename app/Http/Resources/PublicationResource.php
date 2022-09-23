<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class PublicationResource extends JsonResource
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
        $isSingleItemRequest = $request->routeIs('api.v2.publications.show');
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->getTranslatedAttribute('name'),
            'url' => $this->url,
            'img' => $this->image ? $appURL . $this->img : '',
            'medium_img' => $this->image ? $appURL . $this->medium_img : '',
            'description' => $this->getTranslatedAttribute('description'),
            'body' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('body')),
            'seo_title' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('seo_title') ?: $this->getTranslatedAttribute('name')),
            'meta_description' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('meta_description')),
            'meta_keywords' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('meta_keywords')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
