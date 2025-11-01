<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $footer = Footer::first();
        return view('footer.index', compact('footer'));
    }
    public function edit()
    {
        $footer = Footer::first();
        return view('footer.edit', compact('footer'));
    }
    public function update(Request $request, Footer $Footer)
    {

        // dd($request->all());
        $request->validate([
            'contact_address' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'work_days' => 'required|string',
            'work_hour_from' => 'required|string',
            'work_hour_to' => 'required|string',
            'telegram_link' => 'string',
            'whatsapp_link' => 'string',
            'instagram_link' => 'string',
            'youtube_link' => 'string',
            'copyright' => 'required|string',
        ]);

        $Footer->update([
            'contact_address' => $request->contact_address,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'title' => $request->title,
            'body' => $request->body,
            'work_days' => $request->work_days,
            'work_hour_from' => $request->work_hour_from,
            'work_hour_to' => $request->work_hour_to,
            'telegram_link' => $request->telegram_link,
            'whatsapp_link' => $request->whatsapp_link,
            'instagram_link' => $request->instagram_link,
            'youtube_link' => $request->youtube_link,
            'copyright' => $request->copyright,
        ]);
        return redirect()->route('footer.index')->with('success', 'ویرایش فوتر با موفقیت انجام شد.');
    }
}
