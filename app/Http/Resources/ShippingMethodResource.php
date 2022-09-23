<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class ShippingMethodResource extends JsonResource
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
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->getTranslatedAttribute('name'),
            'img' => $this->image ? $appURL . $this->img : '',
            'micro_img' => $this->image ? $appURL . $this->micro_img : '',
            'description' => $this->getTranslatedAttribute('description'),
            'price' => floatval($this->price),
            'order_min_price' => floatval($this->order_min_price),
            'order_max_price' => floatval($this->order_max_price),
        ];
    }
}
