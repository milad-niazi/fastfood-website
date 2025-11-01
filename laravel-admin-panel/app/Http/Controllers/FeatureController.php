<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::all();
        return view('features.index', compact('features'));
    }
    public function edit(Feature $feature)
    {
        return view('features.edit', compact('feature'));
    }
    public function update(Request $request, Feature $feature)
    {

        // dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'icon' => 'required|string',
        ]);

        $feature->update([
            'title' => $request->title,
            'body' => $request->body,
            'icon' => $request->icon,
        ]);
        return redirect()->route('feature.index')->with('success', 'ویرایش ویژگی با موفقیت انجام شد.');
    }
}
