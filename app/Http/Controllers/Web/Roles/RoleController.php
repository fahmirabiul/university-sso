<?php

namespace App\Http\Controllers\Web\Roles;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::paginate(10);
        return view('roles.index', compact('roles'));
    }
}
