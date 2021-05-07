<?php

namespace App\Http\Resources;

use App\Models\Follow;
use App\Models\Like;
use Illuminate\Http\Resources\Json\JsonResource;
use function auth;
use function date;
use function strtotime;

class WorksCollection extends JsonResource
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
                'type' => $this->type,
                'id' => $this->id,
                'user'=>[
                        'avatar' => $this->user->avatar,
                        'nickname' => $this->user->nickname,
                        'user_id' => $this->user->id
                ],
                'followed'=>auth('api')->user()?(Follow::where(['user_id' => auth('api')->user()['id'],'follow_id' => $this->user->id])->first()?true:false):false,
//                'followed'=>$this->user->id===auth('api'),
                'likes' => count($this->likes),
                'has_like' => auth('api')->user() ? Like::where(['work_id'=>$this->id,'user_id'=>auth('api')->user()['id']])->exists() : false,
                'comments' => count($this->comments),
                'cover'=>$this->cover,
                'title' => $this->title,
                'create_time'=>date('Y-m-d H:i', strtotime($this->created_at)),
                'desc'=>$this->desc
        ];
    }
}
