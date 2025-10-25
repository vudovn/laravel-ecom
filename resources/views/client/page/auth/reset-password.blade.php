@extends('client.layout.index')
@section('content')
    <div class="mn-breadcrumb m-b-30">
        <div class="row">
            <div class="col-12">
                <div class="row gi_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="mn-breadcrumb-title">Đặt lại mật khẩu</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="mn-breadcrumb-list">
                            <li class="mn-breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="mn-breadcrumb-item active">Đặt lại mật khẩu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login section -->
    <section class="mn-login p-b-15">
        <div class="mn-title d-none">
            <h2>Đặt lại mật khẩu<span></span></h2>
            <p>Nhập mật khẩu mới để đặt lại mật khẩu</p>
        </div>
        <div class="mn-login-content">
            <div class="mn-login-box">
                <div class="mn-login-wrapper">
                    <div class="mn-login-container">
                        <div class="mn-login-form">
                            <form action="{{ route('auth.reset-password.post') }}" method="post">
                                @csrf
                                <input hidden value="{{ $token }}" name="token">
                                <input hidden value="{{ $email }}" name="email">
                                <span class="mn-login-wrap mb-3">
                                    <label>Mật khẩu</label>
                                    <input class="mb-0" type="password" name="password" placeholder="Nhập mật khẩu...">
                                    @error('password')
                                        <span class="text-danger text-small">* {{ $message }}</span>
                                    @enderror
                                </span>
                                <span class="mn-login-wrap mb-3">
                                    <label>Xác nhận mật khẩu</label>
                                    <input class="mb-0" type="password" name="password_confirmation"
                                        placeholder="Xác nhận mật khẩu...">
                                    @error('password_confirmation')
                                        <span class="text-danger text-small">* {{ $message }}</span>
                                    @enderror
                                </span>
                                <span class="text-end">
                                    <button class="mn-btn-1 btn" type="submit"><span>Đặt lại mật khẩu</span></button>
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
