<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        $messages = ContactUs::all();
        return view('contact.index', compact('messages'));
    }

    public function show($id)
    {
        $message = ContactUs::findOrFail($id);
        return view('contact.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = ContactUs::findOrFail($id);

        $message->delete();
        return redirect()->route('contact.index')->with('warning', ' پیام با موفقیت حذف شد.');
    }
}
