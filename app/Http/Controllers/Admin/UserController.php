<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Province;
use App\Models\Ward;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh sách người dùng';
        $search = $request->search ?? '';
        if ($request->has('search')) {
            $users = User::with('province', 'ward')->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%')
                ->paginate(10); // số lượng người dùng hiển thị trên mỗi trang
        } else {
            $users = User::with('province', 'ward')->paginate(10); // số lượng người dùng hiển thị trên mỗi trang
        }
        return view('admin.page.user.index', compact('users', 'title', 'search'));
    }

    public function create()
    {
        $title = 'Thêm người dùng';
        $provinces = Province::all();
        $wards = Ward::all();
        $roles = Role::all();
        return view('admin.page.user.create', compact('title', 'provinces', 'wards', 'roles'));
    }

    public function store(StoreRequest $request)
    {
        $password = Hash::make($request->password); // mã hóa mật khẩu
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password, //Mật khẩu đã mã hoá sẽ gán vào đây
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'ward_id' => $request->ward_id,
            'address' => $request->address,
            'email_verified_at' => now(), //set thời gian xác nhận email
        ]);
        $user->assignRole($request->role); //gán vai trò cho người dùng
        return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng thành công');
    }

    public function edit($id)
    {
        $title = 'Sửa người dùng';
        $user = User::find($id);
        $provinces = Province::all();
        $wards = Ward::all();
        $roles = Role::all();
        return view('admin.page.user.edit', compact('title', 'user', 'provinces', 'wards', 'roles'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = User::find($id);  //Tìm user đó

        $user->update([  //Cập nhật thông tin người dùng
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'ward_id' => $request->ward_id,
            'address' => $request->address
        ]);

        $user->syncRoles([$request->role]); //cập nhật vai trò cho người dùng
        return redirect()->route('admin.users.index')->with('success', 'Sửa người dùng thành công');
    }

    public function delete($id)
    {
        $user = User::find($id); //Tìm user đó
        $role = $user->getRoleNames()->first(); // lấy role hiện tại của user
        $user->removeRole($role); //Xóa vai trò cho người dùng
        $user->delete(); //Xóa user
        return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công');
    }
}
