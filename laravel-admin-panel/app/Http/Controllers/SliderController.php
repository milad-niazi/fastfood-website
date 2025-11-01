<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'link_title' => 'required|string',
            'link_address' => 'required|string',
            'body' => 'required|string'
        ]);

        Slider::create([
            'title' => $request->title,
            'body' => $request->body,
            'link_title' => $request->link_title,
            'link_address' => $request->link_address
        ]);


        return redirect()->route('slider.index')->with('success', 'اسلایدر با موفقیت انجام شد.');
    }

    public function edit(Slider $slider)
    {
        return view('sliders.edit', compact('slider'));
    }
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string',
            'link_title' => 'required|string',
            'link_address' => 'required|string',
            'body' => 'required|string'
        ]);

        $slider->update([
            'title' => $request->title,
            'body' => $request->body,
            'link_title' => $request->link_title,
            'link_address' => $request->link_address
        ]);
        return redirect()->route('slider.index')->with('success', 'ویرایش اسلایدر با موفقیت انجام شد.');
    }
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('slider.index')->with('warning', ' اسلایدر با موفقیت حذف شد.');
    }
}
