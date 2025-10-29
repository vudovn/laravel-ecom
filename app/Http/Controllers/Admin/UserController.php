<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Province;
use App\Models\Ward;

class UserController extends Controller
{
    public function index()
    {
        $title = 'Danh sách người dùng';
        $users = User::with('province', 'ward')->paginate(10);
        return view('admin.page.user.index', compact('users', 'title'));
    }

    public function create()
    {
        $title = 'Thêm người dùng';
        $provinces = Province::all();
        $wards = Ward::all();
        return view('admin.page.user.create', compact('title', 'provinces', 'wards'));
    }
}
