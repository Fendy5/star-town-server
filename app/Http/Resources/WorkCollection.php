<?php

namespace App\Http\Resources;

use App\Models\Follow;
use Illuminate\Http\Resources\Json\JsonResource;
use function auth;
use function date;
use function strtotime;

class WorkCollection extends JsonResource
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
                'content' => $this->content,
                'user_id'=>$this->user->id,
                'followed'=>auth('api')->user()?(Follow::where(['user_id' => auth('api')->user()['id'],'follow_id' => $this->user->id])->first()?true:false):false,
                'avatar'=>$this->user->avatar,
                'nickname'=>$this->user->nickname,
                'title'=>$this->title,
                'create_time'=>date('Y-m-d H:i', strtotime($this->created_at)),
        ];
    }
}
