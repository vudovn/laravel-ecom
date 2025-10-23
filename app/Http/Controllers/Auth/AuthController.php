<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('client.page.auth.login');
    }

    public function loginPost(Request $request)
    {
        $payload = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email là trường bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Mật khẩu là trường bắt buộc',
        ]);
        if (Auth::attempt($payload)) {
            return redirect()->route('home.index')->with('success', 'Đăng nhập thành công');
        } else {
            return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng')->withInput();
        }
    }

    public function register()
    {
        return view('client.page.auth.register');
    }

    public function registerPost(RegisterRequest $request)
    {
        // logic
        try {
            $user = User::create($request->all());
            $user->assignRole('customer');
            return redirect()->route('auth.login.index')->with('success', 'Đăng ký thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đăng ký thất bại: ' . $e->getMessage())->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login.index')->with('success', 'Đăng xuất thành công');
    }
}
