<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Work;
use Illuminate\Http\Request;
use function auth;
use function dd;

class FollowController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();
        $data = [
                'user_id' =>$user['id'],
                'follow_id' => $request->get('follow_id')
        ];
        if ($follow=Follow::where($data)->first()) {
            $follow->delete();
            return $this->apiResponse(null, 0, '取消关注成功');
        }else{
            Follow::create($data);
            return $this->apiResponse(null, 0, '关注成功');
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
