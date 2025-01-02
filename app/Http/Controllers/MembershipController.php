<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::all();
        return view('admin.memberships.index',compact('memberships'));
    }

    public function create()
    {
        return view('admin.memberships.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'benefits' => 'nullable|string|max:255',
        ]);

        Membership::create($validated);

        return redirect()->route('admin.memberships.index')->with('success','Membership created successfully');
    }

    public function edit(Membership $membership)
    {
        return view('admin.memberships.edit',compact('membership'));
    }

    public function update(Request $request,Membership $membership)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'benefits' => 'nullable|string|max:255',
        ]);

        $membership->update($validated);
        return response()->json([
            'status' => 'success',
            'message' => 'Memberships updated successfully!',
            'redirect_url' => route('admin.memberships.index')
        ]);
    }

    public function destroy(Membership $membership)
    {
        $membership->delete();
        return redirect()->route('admin.memberships.index')->with('success', 'Membership deleted successfully.');
    }


}
