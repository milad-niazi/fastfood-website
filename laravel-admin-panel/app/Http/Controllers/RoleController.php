<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->get();
        return view('roles.index', compact('roles'));
    }
    public function create()
    {
        return view('roles.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('role.index')->with('success', 'نقش با موفقیت ایجاد شد');
    }
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return redirect()->route('role.index')->with('success', 'نقش با موفقیت ویرایش شد');
    }
}
