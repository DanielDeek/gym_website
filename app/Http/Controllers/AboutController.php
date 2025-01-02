<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::all();
        return view('admin.about-us.index', compact('abouts'));
    }

    public function create()
    {
        return view('admin.about-us.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'philosophy_description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        About::create($validated);

        return redirect()->route('admin.about-us.index')->with('success', 'About Us content added successfully!');
    }

    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('admin.about-us.edit', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'philosophy_description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $about = About::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $about->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'About updated successfully!',
            'redirect_url' => route('admin.about-us.index')
        ]);
    }

    public function destroy($id)
    {
        $about = About::findOrFail($id);

        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }

        $about->delete();

        return redirect()->route('admin.about-us.index')->with('success', 'About Us content deleted successfully!');
    }
}
