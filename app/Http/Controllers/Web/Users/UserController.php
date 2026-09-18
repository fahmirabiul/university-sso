<?php

namespace App\Http\Controllers\Web\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Fetch users with their profiles and roles
        $users = User::with(['profile', 'roles'])->paginate(10);
        return view('users.index', compact('users'));
    }
}
