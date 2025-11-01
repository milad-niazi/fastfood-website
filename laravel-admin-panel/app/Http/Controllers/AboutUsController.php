<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $item = AboutUs::first();
        return view('about.index', compact('item'));
    }
    public function edit()
    {
        $item = AboutUs::first();
        return view('about.edit', compact('item'));
    }
    public function update(Request $request)
    {
        $item = AboutUs::first();

        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'link' => 'required|string',
        ]);
        $item->update([
            'title' => $request->title,
            'body' => $request->body,
            'link' => $request->link,
        ]);

        return redirect()->route('about.index')->with('success', 'ویرایش درباره ما با موفقیت انجام شد.');
    }
}
