<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/', 'unique:users,cellphone'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'role_ids' => 'required',
            'role_ids.*' => 'exists:roles,id',
        ]);

        DB::beginTransaction();
        $user = User::create([
            'name' => $request->name,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->roles()->attach($request->role_ids);
        DB::commit();

        return redirect()->route('user.index')->with('success', 'کاربر با موفقیت ایجاد شد');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/', 'unique:users,cellphone,' . $user->id],
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:5',
            'role_ids' => 'required',
            'role_ids.*' => 'exists:roles,id',
        ]);

        DB::beginTransaction();
        $user->update([
            'name' => $request->name,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'password' => $request->has('password') ? Hash::make($request->password) : $user->password
        ]);

        $user->roles()->sync($request->role_ids);
        DB::commit();

        return redirect()->route('user.index')->with('success', 'کاربر با موفقیت ویرایش شد');
    }
}
