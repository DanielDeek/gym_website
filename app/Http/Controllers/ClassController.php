<?php

namespace App\Http\Controllers;

use App\Models\Classs;
use App\Models\Trainer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classs::with('trainer')->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $trainers = Trainer::all();
        return view('admin.classes.create', compact('trainers'));
    }


    public function store(Request $request)
    {
        // Validate the inputs, ensuring time is in 24-hour format (HH:mm)
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'trainer_id' => 'nullable|exists:trainers,id',
            'start_time' => 'required|date_format:H:i',  // 24-hour format validation
            'end_time' => 'required|date_format:H:i',    // 24-hour format validation
            'day_of_week' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        // Store the start_time and end_time as they are in 24-hour format
        $validated['start_time'] = $request->input('start_time');
        $validated['end_time'] = $request->input('end_time');

        // Optional: If you need to convert to 12-hour format for display
        $validated['start_time_12hr'] = Carbon::createFromFormat('H:i', $request->input('start_time'))->format('h:i a');
        $validated['end_time_12hr'] = Carbon::createFromFormat('H:i', $request->input('end_time'))->format('h:i a');

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->store('images', 'public');
            $validated['image'] = basename($filename);
        }

        // Create the class record in the database
        Classs::create($validated);

        // Redirect with success message
        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully.');
    }



    public function edit(Classs $class)
    {
        $trainers = Trainer::all();
        return view('admin.classes.edit', compact('class', 'trainers'));
    }


    public function update(Request $request, $id)
    {
        // Validate the inputs
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'trainer_id' => 'nullable|exists:trainers,id',
            'start_time' => 'required|date_format:H:i',  // Ensure it's in 24-hour format
            'end_time' => 'required|date_format:H:i',    // Ensure it's in 24-hour format
            'day_of_week' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        // No need for conversion if input is already in 24-hour format
        $startTime = $request->input('start_time');  // This is already in 24-hour format
        $endTime = $request->input('end_time');      // This is already in 24-hour format

        // Store the start_time and end_time as they are (24-hour format)
        $validated['start_time'] = $startTime;
        $validated['end_time'] = $endTime;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->store('images', 'public');
            $validated['image'] = basename($filename);
        }

        // Find the existing class by ID
        $class = Classs::findOrFail($id);

        // Update the class record in the database
        $class->update($validated);

        // Redirect with success message
        return response()->json([
            'status' => 'success',
            'message' => 'Class updated successfully!',
            'redirect_url' => route('admin.classes.index')
        ]);
    }


    public function destroy(Classs $class)
    {
        // Delete the image if it exists
        if ($class->image) {
            Storage::disk('public')->delete('images/' . $class->image);
        }

        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }
}
