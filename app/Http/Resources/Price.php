<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Price extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'price' => $this->price
        ];
    }
    public function with($request) {
        return [
            'version'=> '1.0.0',
            'author_name' => 'a-zong'
        ];
    }

}
