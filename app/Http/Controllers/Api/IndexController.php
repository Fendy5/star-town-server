<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorksCollection;
use App\Models\Like;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use function count;
use function dd;

class IndexController extends Controller
{
    protected Work $work;

    public function __construct(Work $work)
    {
        $this->work = $work;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
//        $homeRecommend = $this->work->getWorkList();
        $homeRecommend = $this->work->getWorkByLike(0,'likes',8);
        $rank = $this->work->getWorkByLike();
        $data = [
                'home_recommend' => WorksCollection::collection($homeRecommend),
                'ranks' => WorksCollection::collection($rank)
        ];
        return $this->apiResponse($data);
    }

    public function getRecommendList(): \Illuminate\Http\JsonResponse
    {
        $homeRecommend = $this->work->getWorkByLike(0,'likes',8);
        return $this->apiResponse(['works'=> WorksCollection::collection($homeRecommend)]);
    }

    public function getArtList(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->apiResponse(['arts'=>WorksCollection::collection($this->work->getWorkByLike($request->get('type')))]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
