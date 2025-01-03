<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\Membership;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::all();
        $query = Member::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $members = $query->get();

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        $memberships = Membership::all();
        return view('admin.members.create', compact('memberships'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email', // Ensure unique email in the users table
            'phone' => 'nullable|string|max:15',
            'membership_id' => 'required|exists:memberships,id',
            'start_date' => 'required|date',
        ]);

        // Create the User record first
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'],
            'role' => 'member', // Set the role as 'member'
            'password' => bcrypt('default_password'), // Provide a default password
        ]);

        // Fetch the selected membership and calculate the end date
        $membership = Membership::findOrFail($validated['membership_id']);
        $duration = $membership->duration;
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = (clone $startDate)->addMonths($duration);

        // Create the Member record and associate it with the user
        Member::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'membership_id' => $validated['membership_id'],
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return redirect()->route('admin.members.index')->with('success', 'Member created successfully.');
    }

    public function edit(Member $member)
    {
        $memberships = Membership::all();
        return view('admin.members.edit', compact('member', 'memberships'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $member->user->id,
            'phone' => 'nullable|string|max:15',
            'membership_id' => 'required|exists:memberships,id',
            'start_date' => 'required|date',
        ]);
        // Update the User details
        $user = $member->user;
        if ($user) {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone'],
            ]);
        }

        // Update the membership details and calculate the end date
        $membership = Membership::findOrFail($validated['membership_id']);
        $duration = $membership->duration;
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = (clone $startDate)->addMonths($duration);

        // Update the Member details
        $member->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'membership_id' => $validated['membership_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $endDate,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Member updated successfully!',
            'redirect_url' => route('admin.members.index')
        ]);
    }

    public function destroy(Member $member)
    {
        // Retrieve the associated user
        $user = $member->user;

        // Delete the member record
        $member->delete();

        // Delete the associated user if exists
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.members.index')->with('success', 'Member and associated user deleted successfully.');
    }

}
