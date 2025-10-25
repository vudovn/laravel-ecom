@extends('client.layout.index')

@section('content')
    <div class="mn-breadcrumb m-b-30">
        <div class="row">
            <div class="col-12">
                <div class="row gi_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="mn-breadcrumb-title">Trang đăng nhập</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="mn-breadcrumb-list">
                            <li class="mn-breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="mn-breadcrumb-item active">Trang đăng nhập</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login section -->
    <section class="mn-login p-b-15">
        <div class="mn-title d-none">
            <h2>Đăng nhập<span></span></h2>
            <p>Nhập email và mật khẩu để đăng nhập</p>
        </div>
        <div class="mn-login-content">
            <div class="mn-login-box">
                <div class="mn-login-wrapper">
                    <div class="mn-login-container">
                        <div class="mn-login-form">
                            <form action="{{ route('auth.login.post') }}" method="post">
                                @csrf
                                <span class="mn-login-wrap mb-3">
                                    <label>Email</label>
                                    <input value="{{ old('email') }}" class="mb-0" type="email" name="email"
                                        placeholder="Nhập email...">
                                    @error('email')
                                        <span class="text-danger text-small">* {{ $message }}</span>
                                    @enderror
                                </span>
                                <span class="mn-login-wrap mb-3">
                                    <label>Mật khẩu</label>
                                    <input class="mb-0" type="password" name="password" placeholder="Nhập mật khẩu...">
                                    @error('password')
                                        <span class="text-danger text-small">* {{ $message }}</span>
                                    @enderror
                                </span>
                                <span class="mn-login-wrap mn-login-fp">
                                    <span class="mn-remember">
                                        <input type="checkbox" value="">
                                        Nhớ tôi
                                        <span class="checked"></span>
                                    </span>
                                    <label><a href="">Quên mật khẩu?</a></label>
                                </span>
                                <span class="mn-login-wrap mn-login-btn">
                                    <span><a href="{{ route('auth.register.index') }}" class="">Tạo tài
                                            khoản?</a></span>
                                    <button class="mn-btn-1 btn" type="submit"><span>Đăng nhập</span></button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mn-login-box d-n-991">
                <div class="mn-login-img">
                    <img src="https://maraviyainfotech.com/projects/mantu-html/assets/img/common/about-3.png"
                        alt="login">
                </div>
            </div>
        </div>
    </section>
@endsection
