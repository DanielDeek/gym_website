<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            // Save the image to the public/images directory
            $filename = $request->file('image')->store('images', 'public');
            $data['image'] = basename($filename); // Save only the filename
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            // Delete the old image
            if ($service->image) {
                Storage::disk('public')->delete('images/' . $service->image);
            }

            // Save the new image
            $filename = $request->file('image')->store('images', 'public');
            $data['image'] = basename($filename); // Save only the filename
        }

        $service->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Trainer updated successfully!',
            'redirect_url' => route('admin.services.index')
        ]);
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete('images/' . $service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }

}
