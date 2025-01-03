<?php

namespace App\Http\Controllers;

use App\Models\Classs;
use App\Models\MemberClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MemberClassController extends Controller
{
    public function index(Request $request)
    {
        $memberClasses = MemberClass::with('class')->get();
        $query = MemberClass::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $memberClasses = $query->get();

        return view('admin.memberClass.index',compact('memberClasses'));
    }

    public function create()
    {
        $classes = Classs::all(); // Get all classes for selection
        return view('admin.memberClass.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:member_class,email',
            'phone' => 'nullable|string',
            'class_id' => 'required|exists:classes,id',
        ]);

        MemberClass::create($validated);

        return redirect()->route('admin.memberClass.index')->with('success', 'Member created successfully.');
    }

    public function edit($id)
    {
        $memberClass = MemberClass::find($id);
        $classes = Classs::all();

        if (!$memberClass) {
            return redirect()->route('admin.memberClass.index')->with('error', 'Member class not found');
        }

        return view('admin.memberClass.edit', compact('memberClass', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:member_class,email,' . $id,
            'phone' => 'nullable|string',
            'class_id' => 'required|exists:classes,id',
        ]);

        $memberClass = MemberClass::find($id);

        if (!$memberClass) {
            return response()->json(['message' => 'Member class not found'], 404);
        }

        $memberClass->update($request->all());

        return response()->json([
            'message' => 'Member class updated successfully!',
            'data' => $memberClass
        ]);
    }

    public function destroy($id)
    {
        $memberClass = MemberClass::find($id);

        if (!$memberClass) {
            return response()->json(['message' => 'Member class not found'], 404);
        }

        $memberClass->delete();

        return redirect()->route('admin.memberClass.index');
    }

}
