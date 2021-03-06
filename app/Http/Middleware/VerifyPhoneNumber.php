<?php

namespace App\Http\Middleware;

use App\Exceptions\MessageResponseBody;
use Closure;
use Illuminate\Http\Request;
use Validator;

/**
 * 验证手机号码
 */
class VerifyPhoneNumber
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|cn_phone',
        ]);

        if ($validator->fails()) {
            return app(MessageResponseBody::class, [
                'code' => 1000,
            ])->setStatusCode(403);
        }

        return $next($request);
    }
}
