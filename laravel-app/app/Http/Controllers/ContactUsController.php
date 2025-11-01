<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('contact');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'body' => 'required'
        ]);
        ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'body' => $request->body
        ]);
        return redirect()->back()->with('success', 'پیام با موفقیت فرستاده شد.');
    }
}
