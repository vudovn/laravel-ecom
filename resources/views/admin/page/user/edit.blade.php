@extends('admin.layout.index')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form method="post" action="{{ route('admin.users.update', $user->id) }}" class="row">
                        @csrf
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input value="{{ old('name', $user->name) }}" type="text" class="form-control"
                                    placeholder="Nhập họ và tên" name="name">
                                @error('name')
                                    <span class="text-danger text-small">* {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input value="{{ old('email', $user->email) }}" type="text" class="form-control"
                                    placeholder="Nhập email" name="email">
                                @error('email')
                                    <span class="text-danger text-small">* {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input value="{{ old('phone', $user->phone) }}" type="text" class="form-control"
                                    placeholder="Nhập số điện thoại" name="phone">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tỉnh/Thành phố</label>
                                <select name="province_id" id="province_id" class="form-control select_province select2">
                                    <option value="">Chọn tỉnh/thành phố</option>
                                    @foreach ($provinces as $province)
                                        <option
                                            {{ old('province_id', $user->province_id) == $province->id ? 'selected' : '' }}
                                            value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quận/Huyện</label>
                                <select name="ward_id" id="ward_id" class="form-control select_ward select2">
                                    <option value="">Chọn quận/huyện</option>
                                    @foreach ($wards as $ward)
                                        <option {{ old('ward_id', $user->ward_id) == $ward->id ? 'selected' : '' }}
                                            value="{{ $ward->id }}">{{ $ward->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ chi tiết</label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ chi tiết"
                                    value="{{ old('address', $user->address) }}" name="address">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Vai trò</label>
                                <select name="role" id="role" class="form-control">
                                    @foreach ($roles as $role)
                                        <option
                                            {{ old('role', $user->getRoleNames()->first()) == $role->name ? 'selected' : '' }}
                                            value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-between gap-2">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
                                <button type="submit" class="btn btn-primary">Sửa người dùng</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
