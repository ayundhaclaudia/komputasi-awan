<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::select(
            'id',
            'name',
            'email',
            'role',
            'is_premium',
            'created_at'
        )->latest()->get();

        return view('admin.users', compact('users'));
    }
}
