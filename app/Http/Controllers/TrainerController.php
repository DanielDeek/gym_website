<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::all();
        return view('admin.trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('admin.trainers.create');
    }

    public function store(Request $request)
{
    // Validate the input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|unique:users,email',
        'phone' => 'nullable|string|max:15',
        'specialization' => 'nullable|string|max:255',
        'bio' => 'nullable|string|max:1000',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // Save the image in the public storage directory
        $filename = $request->file('image')->store('images', 'public');
        $validated['image'] = basename($filename); // Save only the filename
    }

    // Create the User record
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone_number' => $validated['phone'],
        'role' => 'trainer',
        'password' => bcrypt('default_password'),
    ]);

    // Create the Trainer record
    Trainer::create(array_merge($validated, ['user_id' => $user->id]));

    return redirect()->route('admin.trainers.index')->with('success', 'Trainer created successfully.');
}


    public function edit(Trainer $trainer)
    {
        return view('admin.trainers.edit', compact('trainer'));
    }

    public function update(Request $request, Trainer $trainer)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|unique:users,email,' . $trainer->user->id,
        'phone' => 'nullable|string|max:15',
        'specialization' => 'nullable|string|max:255',
        'bio' => 'nullable|string|max:1000',
        'image' => 'nullable|image|max:2048',
    ]);

    $user = $trainer->user;
    if ($user) {
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'],
        ]);
    }

    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($trainer->image) {
            Storage::disk('public')->delete('images/' . $trainer->image);
        }

        // Save the new image
        $filename = $request->file('image')->store('images', 'public');
        $validated['image'] = basename($filename);
    }

    $trainer->update($validated);

    return response()->json([
        'status' => 'success',
        'message' => 'Trainer updated successfully!',
        'redirect_url' => route('admin.trainers.index')
    ]);
}

    public function destroy(Trainer $trainer)
    {
        // Retrieve the associated user
        $user = $trainer->user;

        // Delete the trainer record
        $trainer->delete();

        // Delete the associated user if exists
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer and associated user deleted successfully.');
    }
}
