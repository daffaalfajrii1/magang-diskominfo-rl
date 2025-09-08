<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
         $users = \App\Models\User::query()
        ->where('role', 'user')                // ⬅️ hanya user
        ->with('internship')
        ->orderBy('created_at','desc')
        ->paginate(20);

        return view('admin.users.index', compact('users'));
    }
}
