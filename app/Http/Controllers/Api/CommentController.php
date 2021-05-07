<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentsCollection;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function auth;

class CommentController extends Controller
{

    protected Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->middleware('auth:api')->except(['index','show']);
        $this->comment = $comment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $comments = CommentsCollection::collection($this->comment->where(['work_id'=>\request('work_id'),'to_id'=>null])->get());
        return $this->apiResponse(['comments' => $comments], 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = [
                'user_id' => auth('api')->user()->id,
                'content' => $request->get('comment'),
                'work_id'=>$request->get('work_id')
        ];
        $data['to_id'] = $request->get('to_id') ? $request->get('to_id') : null;
        $data['comment_id'] = $request->get('comment_id') ? $request->get('comment_id') : null;
        $this->comment->create($data);
        return $this->apiResponse(null, 0, '发表成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->comment->where(['id'=>$id])->delete();
        return $this->apiResponse(null, 0,'删除成功');
    }
}
