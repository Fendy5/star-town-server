<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkCollection;
use App\Http\Resources\WorksCollection;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Work;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function auth;
use function dd;

class WorkController extends Controller
{
    protected Work $work;

    public function __construct(Work $work)
    {
        $this->middleware('auth:api')->except(['index','show']);
        $this->work = $work;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $type = \request('type');
        $page = \request(['pageNo','pageSize'])?\request(['pageNo','pageSize']):['pageSize'=>10,'pageNo'=>1];
        $page['order_field'] = 'id';
        $page['order'] = 'desc';
        $keyword = \request('keywords');
        $ccId = \request('cc_id');
        $works = $this->work->getWorkByType($type, $page,$ccId,$keyword);
        return $this->apiResponse([
                'works'=>WorksCollection::collection($works),
                'total'=>$works->total(),
                'text_count' => $keyword ? $this->work->getWorkByType(7,['pageSize'=>999999,'pageNo'=>1, 'order_field'=>'id', 'order'=>'desc'],$ccId,$keyword)->total() : null,
                'art_count' => $keyword ? $this->work->getWorkByType(8, ['pageSize'=>999999,'pageNo'=>1, 'order_field'=>'id', 'order'=>'desc'],$ccId,$keyword)->total() : null,
                'pageNo'=>$works->currentPage(),
                'pageSize'=>$works->perPage()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = \request(['content','type','title','desc']);
        if ($cover=\request('cover')) {
            $data['cover'] = $cover;
        }
        $data['user_id'] = auth('api')->user()['id'];
        $res = $this->work->addWork($data)?'success':'fail';
        return $this->apiResponse(['msg' => $res],0,'发布成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $work= $this->work->find($id);
        $data = [
                'work' => new WorkCollection($work),
                'comments_count' => Comment::where(['work_id' => $id])->count(),
                'likes' => Like::where(['work_id' => $id])->count()
        ];
        return $this->apiResponse($data);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
