<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\LikesCollection;
use App\Http\Resources\WorksCollection;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Work;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use function auth;
use function password_hash;
use const PASSWORD_DEFAULT;

class UserController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //  注册
    public function register(): \Illuminate\Http\JsonResponse
    {
        $data = [
                'nickname' => \request('nickname'),
                'phone' => \request('phone'),
                'password'=> password_hash(\request('password'),PASSWORD_DEFAULT)
        ];
        $this->user->register($data);
        return $this->apiResponse(null, 0, '注册成功~');
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $id = \request('id') ? \request('id') : auth('api')->user()->id;
        $user=User::where(['id'=>$id])->withCount(['comments', 'likes', 'works','follows','fans'])->first();
        $user['circle']=$user->circle?$user->circle->name:null;
        return $this->apiResponse(['user' => $user], 0);
    }

    // 我点赞的
    public function myLike(): \Illuminate\Http\JsonResponse
    {
        $id = \request('id') ? \request('id') : auth('api')->user()->id;
        $works= LikesCollection::collection(User::find($id)->likes);
        return $this->apiResponse(['works' => $works]);
    }

    // 我的评论
    public function myComment(): \Illuminate\Http\JsonResponse
    {
        $id = \request('id') ? \request('id') : auth('api')->user()->id;
        $comments = CommentCollection::collection(User::find($id)->comments);
        return $this->apiResponse(['comments' => $comments]);
    }

    // 我创作的
    public function myCreate()
    {
        $id = \request('id') ? \request('id') : auth('api')->user()->id;
        $works = WorksCollection::collection(User::find($id)->works);
        $likes_count = Like::whereHas('work', function (Builder $query) use ($id) {
            $query->where(['user_id'=>$id]);
        })->get()->count();
        $comments_count = Comment::whereHas('work', function (Builder $query) use ($id) {
            $query->where(['user_id'=>$id]);
        })->get()->count();
        return $this->apiResponse(['works' => $works,'likes_count'=>$likes_count,'comments_count'=>$comments_count]);
    }

    //  我关注的
    public function myFollow(): \Illuminate\Http\JsonResponse
    {
        $id = \request('id') ? \request('id') : auth('api')->user()->id;
        $user = User::find($id);
        $users = $user->follows;
        return $this->apiResponse(['users' => $users]);
    }

    //  我的粉丝
    public function myFans(): \Illuminate\Http\JsonResponse
    {
        $id = \request('id') ? \request('id') : auth('api')->user()->id;
        $user = User::find($id);
        $users = $user->fans;
        return $this->apiResponse(['fans' => $users]);
    }

}
