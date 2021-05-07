<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function count;
use function date;
use function strtotime;

class CommentCollection extends JsonResource
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
                'avatar'=>$this->user->avatar,
                'nickname'=>$this->user->nickname,
                'content'=>$this->content,
                'likes_count'=>count($this->work->likes),
                'comments_count'=>count($this->work->comments),
                'create_time'=>date('Y-m-d H:i:s', strtotime($this->created_at)),
                'work'=>[
                        'work_id'=>$this->work->id,
                        'type' => $this->work->type,
                        'title' =>$this->work->title
                ]
        ];
    }
}
