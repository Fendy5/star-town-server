<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CirclesCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'id'=>$this->id,
                'name'=>$this->name,
                'users'=>$this->users,
                'cover'=>$this->cover,
        ];
    }
}
