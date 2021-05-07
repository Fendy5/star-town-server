<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use function dd;
use function next;
use function response;
use function route;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }
        if ($this->auth->guard($guards[0])->check()) {
            return $next($request);
        }else if ($request->server('HTTP_AUTHORIZATION')){
            return response()->json([
                    'code'    => 1,
                    'message' => '您的登录状态已失效，请重新登录',
                    'data' => null
            ]);
        } else {
            return response()->json([
                    'code'    => 1,
                    'message' => '您还没登录，请先登录',
                    'data' => null
            ]);
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        return response()->json([
                'code'    => 1,
                'message' => '登录状态无效',
                'data' => null
        ]);
    }
}
