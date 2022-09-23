<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'phone_number_verified_at' => $this->phone_number_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'image' => [
                'original' => $appURL . $this->img,
                'small' => $appURL . $this->small_img,
                'medium' => $appURL . $this->medium_img,
            ],
        ];
    }
}
