<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // middleware kiểm tra đăng nhập cho các trang login, register
        if (!Auth::check()) {
            // nếu mà chưa đăng nhập thì cho phép truy cập
            return $next($request);
        }
        // nếu mà đã đăng nhập thì chuyển hướng về trang home
        return redirect()->route('home.index')->with('error', 'Bạn đã đăng nhập, vui lòng đăng xuất để truy cập trang này');
    }
}
