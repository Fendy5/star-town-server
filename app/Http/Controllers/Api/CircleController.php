<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CirclesCollection;
use App\Models\Circle;
use App\Models\User;
use Illuminate\Http\Request;
use function auth;

class CircleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keywords = \request('keywords');
        $circles = (new Circle())->getCircleList($keywords);
        return $this->apiResponse(['circles'=>CirclesCollection::collection($circles),'count'=>$keywords?$circles->count():null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = (new User())->getUserByPhone($request->get('phone'));
        if ($user) {
            $circle=Circle::create(['name' => $request->get('cp_name'),'cover'=>$user->avatar]);
            $user->update(['cc_id' => $circle->id]);
            User::find( auth('api')->user()->id)->update(['cc_id' => $circle->id]);
            return $this->apiResponse(null, 0, '入驻成功');
        } else {
            return $this->apiResponse(null, 1, '找不到该手机号码的用户');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $circle = Circle::find($id);
        return $this->apiResponse(['circle' => $circle]);
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
