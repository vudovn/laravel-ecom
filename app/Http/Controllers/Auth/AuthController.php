<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Jobs\SendVeryEmail;

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
            // kiểm tra xem email_verified_at có = null không, nếu = null thì logout và trả về thông báo
            if (Auth::user()->email_verified_at == null) {
                Auth::logout(); //đăng xuất
                return redirect()->route('auth.login.index')->with('error', 'Vui lòng xác nhận email để đăng nhập');
            }
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
            // tạo token xác nhận email
            $token = Str::random(60);
            $user->very_mail_token = $token;
            $user->save();
            // gửi email xác nhận email
            SendVeryEmail::dispatch($user->email, $user->name, $user->very_mail_token);
            return redirect()->route('auth.login.index')->with('success', 'Đăng ký thành công, vui lòng kiểm tra email để xác nhận tài khoản');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đăng ký thất bại: ' . $e->getMessage())->withInput();
        }
    }

    public function very($token)
    {
        // kiểm tra trong bảng user , cột  very_mail_token có = cái token được truyền vào
        $user = User::where('very_mail_token', $token)->first();
        if ($user) {
            $user->very_mail_token = null; //xoá dữ liệu trong cột very_mail_token
            $user->email_verified_at = now(); //set cột  email_verified_at thời gian xác nhận email
            $user->save(); //Lưu
            return redirect()->route('auth.login.index')->with('success', 'Xác nhận tài khoản thành công, vui lòng đăng nhập');
        } else {
            return redirect()->route('auth.login.index')->with('error', 'Xác nhận tài khoản thất bại');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login.index')->with('success', 'Đăng xuất thành công');
    }
}
