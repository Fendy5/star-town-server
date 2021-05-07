<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use function auth;
use function bcrypt;
use function password_hash;
use function password_verify;
use const PASSWORD_DEFAULT;

class AuthController extends Controller
{

    protected User $user;

    /**
     * Create a new AuthController instance.
     * 要求附带email和password（数据来源users表）
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        // 这里额外注意了：官方文档样例中只除外了『login』
        // 这样的结果是，token 只能在有效期以内进行刷新，过期无法刷新
        // 如果把 refresh 也放进去，token 即使过期但仍在刷新期以内也可刷新
        // 不过刷新一次作废
//        $this->middleware('auth:api', ['except' => ['login']]);
        // 另外关于上面的中间件，官方文档写的是『auth:api』
        // 但是我推荐用 『jwt.auth』，效果是一样的，但是有更加丰富的报错信息返回
        $this->user = $user;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(): \Illuminate\Http\JsonResponse
    {
        $user = $this->user->getUserByPhone(\request('phone'));
        if ($user && password_verify(\request('password'), $user->password)) {
            $user['password'] = null;
            $token = auth('api')->login($user);
            return $this->apiResponse(['token' => $token],0,'登录成功');
        } else {
            return $this->apiResponse('', 1, '用户名或密码错误');
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo(): \Illuminate\Http\JsonResponse
    {
        $user = auth('api')->user();
        if ($user) {
            $user['password'] = null;
            return $this->apiResponse(['user' => $user]);
        } else {
            return $this->apiResponse(null, 1, 'token无效');
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
