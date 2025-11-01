<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required',
        ]);

        Category::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return redirect()->route('category.index')->with('success', 'دسته بندی با موفقیت ایجاد شد.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required',
        ]);

        $category->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return redirect()->route('category.index')->with('success', 'ویرایش دسته بندی با موفقیت انجام شد.');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('warning', ' دسته بندی با موفقیت حذف شد.');
    }
}
