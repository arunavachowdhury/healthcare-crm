<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminDashboardController extends Controller
{
    public function index(Request $request) {
        $users = User::all();
        $roles = [UserRole::ADMIN, UserRole::AGENT, UserRole::DOCTOR, UserRole::PAITIENT, UserRole::MANAGER];

        return view('admin_dashboard', compact('users', 'roles'));
    }

    public function syncUserRoles(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required'
        ]);

        $user = User::find($request->user_id);

        $user->assignRole($request->role);

        return redirect()->back()->with('status', 'user-role-updated');
    }
}
