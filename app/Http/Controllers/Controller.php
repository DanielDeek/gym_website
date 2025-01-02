<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Classs;
use App\Models\Contact;
use App\Models\Footer;
use App\Models\Home;
use App\Models\Membership;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Controller
{
    public function showHomeContent()
    {
        $home = Home::latest()->first();
        $about = About::latest()->first();
        $services = Service::all();

        return view('home',compact('services','home','about'));
    }



    public function showClasses()
    {
        $classes = Classs::all();
        return view('classes',compact('classes'));
    }

    public function showPricing()
    {
        $memberships = Membership::all();
        $classes = Classs::all();
        return view('pricing',compact('memberships','classes'));
    }

    public function showForm()
    {
        return view('contactus');
    }

    // Handle form submission
    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        Contact::create($validated);

        return redirect()->route('contactus')->with('success', 'Message sent successfully.');
    }

    public function showChangePasswordForm()
    {
        return view('change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The current password does not match our records.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('home')->with('success', 'Password changed successfully.');
    }
}
