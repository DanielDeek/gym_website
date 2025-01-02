<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $homes = Home::all();
        return view('admin.home.index', compact('homes'));
    }

    public function create()
    {
        return view('admin.home.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'background_image' => 'nullable|image|max:2048', // Validate as an image file
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'operating_hours' => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');

            // Store the file in the 'public/images' directory
            $filename = $file->store('images', 'public');

            // Save the filename (or path) to the validated data
            $validated['background_image'] = $filename; // Full file path relative to storage/public
        }

        // Create the new record
        Home::create($validated);

        // Redirect with success message
        return redirect()->route('admin.home.index')->with('success', 'Home content created successfully!');
    }



    public function edit($id)
    {
        $home = Home::findOrFail($id);
        return view('admin.home.edit', compact('home'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'background_image' => 'nullable|image|max:2048', // Validate as an image file
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'operating_hours' => 'nullable|string',
        ]);

        // Find the Home record
        $home = Home::findOrFail($id);

        // Handle the file upload if a new image is provided
        if ($request->hasFile('background_image')) {
            // Delete the old image if it exists
            if ($home->background_image) {
                Storage::disk('public')->delete($home->background_image);
            }

            // Store the new file in the 'public/images' directory
            $filename = $request->file('background_image')->store('images', 'public');

            // Save the filename (or path) to the validated data
            $validated['background_image'] = $filename; // Full file path relative to storage/public
        }

        // Update the Home record with the validated data
        $home->update($validated);

        // Redirect with success message
        return redirect()->route('admin.home.index')->with('success', 'Home content updated successfully!');
    }


    public function destroy($id)
    {
        $home = Home::findOrFail($id);

        if ($home->background_image) {
            Storage::disk('public')->delete($home->background_image);
        }

        $home->delete();

        return redirect()->route('admin.home.index')->with('success', 'Home content deleted successfully!');
    }
}
