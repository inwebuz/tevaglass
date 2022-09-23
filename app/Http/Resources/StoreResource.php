<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
        $isSingleItemRequest = $request->routeIs('api.v2.stores.show');
        return [
            'id' => $this->id,
            // 'region_id' => $this->region_id,
            'name' => $this->getTranslatedAttribute('name'),
            'img' => $this->image ? $appURL . $this->img : '',
            'small_img' => $this->image ? $appURL . $this->small_img : '',
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->getTranslatedAttribute('address'),
            'landmark' => $this->getTranslatedAttribute('landmark'),
            'work_hours' => $this->getTranslatedAttribute('work_hours'),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'map_code' => $this->map_code,
            'seo_title' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('seo_title') ?: $this->getTranslatedAttribute('name')),
            'meta_description' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('meta_description')),
            'meta_keywords' => $this->when($isSingleItemRequest, $this->getTranslatedAttribute('meta_keywords')),
        ];
    }
}
