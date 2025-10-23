<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // middleware kiểm tra đăng nhập
        if (Auth::check()) {
            // nếu mà đã đăng nhập thì cho phép truy cập
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff')) {
                return $next($request);
            }
            return redirect()->route('home.index')->with('error', 'Bạn không có quyền truy cập trang này');
        }
        return redirect()->route('auth.login.index')->with('error', 'Vui lòng đăng nhập để truy cập trang này');
    }
}
