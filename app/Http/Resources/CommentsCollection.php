<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function date;
use function dd;
use function strtotime;

class CommentsCollection extends JsonResource
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
                'to_user' => new UserCollection($this->to_user),
//                'parent_id' => $this->
                'avatar'=>$this->user->avatar,
                'user_id'=>$this->user->id,
                'nickname'=>$this->user->nickname,
                'create_time'=>date('Y-m-d H:i:s', strtotime($this->created_at)),
                'content'=>$this->content,
                'sub_comments' => CommentsCollection::collection($this->comments)
        ];
    }
}
