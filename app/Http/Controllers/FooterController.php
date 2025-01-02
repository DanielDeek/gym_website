<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $footers = Footer::all();
        return view('admin.footer.index',compact('footers'));
    }

    public function create()
    {
        return view('admin.footer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10',
            'email' => 'nullable|email|unique:users,email',
        ]);

        Footer::create($validated);
        return redirect()->route('admin.footer.index')->with('success','Footer content has been added');
    }

    public function edit($id)
    {
        $footer = Footer::findOrFail($id);
        return view('admin.footer.edit',compact('footer'));
    }

    public function update(Request $request, $id)
    {
        $footer = Footer::findOrFail($id);
        $validated = $request->validate([
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10',
            'email' => 'nullable|email|unique:users,email',
        ]);

        $footer->update($validated);
        return response()->json([
            'status' => 'success',
            'message' => 'Footer updated successfully!',
            'redirect_url' => route('admin.footer.index')
        ]);
    }

    public function destroy($id)
    {
        $footer = Footer::findOrFail($id);
        $footer->delete();
        return redirect()->route('admin.footer.index')->with('success', 'Footer deleted successfully!');
    }


}
