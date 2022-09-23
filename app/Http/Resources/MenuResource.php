<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $isSingleItemRequest = $request->routeIs('api.v2.menus.show');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'menuItems' => $this->when($isSingleItemRequest, MenuItemResource::collection($this->whenLoaded('menuItems'))),
        ];
    }
}
