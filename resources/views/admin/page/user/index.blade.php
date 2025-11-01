@extends('admin.layout.index')

@section('content')
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center p-4 pb-sm-2">
                    <form action="{{ route('admin.users.index') }}" method="get" class="d-flex gap-2">
                        <input value="{{ old('search', $search) }}" type="text" class="form-control"
                            placeholder="Tìm kiếm người dùng" name="search">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-search f-18"></i></button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary"><i
                                class="ti ti-refresh f-18"></i></a>
                    </form>
                    <a href="{{ route('admin.users.create.index') }}"
                        class="btn btn-primary d-inline-flex align-items-center gap-2">
                        <i class="ti ti-plus f-18"></i>
                        Thêm người dùng
                    </a>
                </div>
                <div class="table-responsive">
                    <div class="datatable-wrapper datatable-loading no-footer searchable fixed-columns">
                        <div class="datatable-container">
                            <table class="table table-hover datatable-table" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th class="text-end">#</th>
                                        <th>Avatar</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Thông tin</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td class="text-end">{{ $key + 1 }}</td>
                                            <td>
                                                <img src="https://ui-avatars.com/api/?background=random&name={{ $user->name }}"
                                                    alt="user-image" class="wid-40 rounded">
                                            </td>
                                            <td>{{ $user->name }} <span
                                                    class="badge bg-light-{{ $user->getRoleNames()->first() == 'admin' ? 'danger' : 'success' }} f-12">{{ $user->getRoleNames()->first() }}</span>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span> - Tỉnh/Thành phố: {{ $user->province->name ?? '-' }}</span> <br />
                                                <span> - Quận/Huyện: {{ $user->ward->name ?? '-' }}</span> <br />
                                                <span> - Địa chỉ: {{ $user->address ?? '-' }}</span><br />
                                                <span> - Số điện thoại: {{ $user->phone ?? '-' }}</span> <br />
                                            </td>
                                            </td>
                                            <td>
                                                @php $status = $user->is_active == 'active' ? 'Bình thường' : 'Bị khoá'; @endphp
                                                <span
                                                    class="badge bg-light-{{ $user->is_active == 'active' ? 'success' : 'danger' }} f-12">{{ $status }}</span>
                                            </td>
                                            <td class="text-center">
                                                <ul class="list-inline me-auto mb-0">
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="Sửa">
                                                        <a href="{{ route('admin.users.edit.index', $user->id) }}"
                                                            class="avtar avtar-xs btn-link-success btn-pc-default">
                                                            <i class="ti ti-edit-circle f-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="Xoá">
                                                        <form {{-- Hộp thoại xác nhận có xoá user này hay không --}}
                                                            onSubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng {{ $user->name }}  này không?')"
                                                            action="{{ route('admin.users.delete', $user->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit"
                                                                class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                                <i class="ti ti-trash f-18"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
