@extends('admin.layout.index')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form method="post" action="{{ route('admin.users.store') }}" class="row">
                        @csrf
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" placeholder="Nhập họ và tên" name="name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" placeholder="Nhập email" name="email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Xác nhận mật khẩu</label>
                                <input type="text" class="form-control" placeholder="Nhập mật khẩu xác nhận"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="phone">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tỉnh/Thành phố</label>
                                <select name="province_id" id="province_id" class="form-control select_province">
                                    <option value="">Chọn tỉnh/thành phố</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quận/Huyện</label>
                                <select name="ward_id" id="ward_id" class="form-control select_ward" disabled>
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ chi tiết</label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ chi tiết"
                                    name="address">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
