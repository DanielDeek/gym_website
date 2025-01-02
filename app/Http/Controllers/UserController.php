<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use App\Models\Trainer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $memberships = Membership::all();
        $trainer = new Trainer();
        return view('admin.users.create', compact('memberships','trainer'));
    }

    public function store(Request $request)
    {
        // Validation remains the same
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,member,trainer,guest',
            'phone_number' => 'nullable|string|max:10',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone_number' => $request->phone_number,
        ]);

        if ($request->role === 'trainer') {
            $trainer = Trainer::firstOrNew(['email' => $user->email]);
            $trainer->user_id = $user->id;
            $trainer->name = $user->name;
            $trainer->email = $user->email;
            $trainer->phone = $user->phone_number;
            $trainer->specialization = $request->specialization;
            $trainer->bio = $request->bio;
            if ($request->hasFile('image')) {
                // Save the uploaded image to the storage directory
                $filename = $request->file('image')->store('images', 'public');
                $trainer->image = basename($filename); // Store only the filename
            }
            $trainer->save();
        }

        if ($request->role === 'member') {
            $membership = Membership::findOrFail($request->membership_id);
            $startDate = Carbon::parse($request->start_date);
            $endDate = $startDate->addMonths($membership->duration);

            Member::create([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone_number,
                'membership_id' => $request->membership_id,
                'start_date' => $request->start_date,
                'end_date' => $endDate,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Retrieve related models based on the user's role
        $trainer = Trainer::where('email', $user->email)->first();
        $member = Member::where('email', $user->email)->first();

        $memberships = Membership::all();
        return view('admin.users.edit', compact('user', 'trainer', 'member', 'memberships'));
    }

    public function update(Request $request, $id)
    {
        $user = User::with('trainer', 'member')->find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,member,trainer,guest',
            'phone_number' => 'nullable|string|max:15,'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
        ]);

        if ($request->role === 'trainer') {
            $trainer = Trainer::firstOrNew(['email' => $user->email]);
            $trainer->user_id = $user->id;
            $trainer->name = $user->name;
            $trainer->email = $user->email;
            $trainer->phone = $user->phone_number;
            $trainer->specialization = $request->specialization;
            $trainer->bio = $request->bio;
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($trainer->image) {
                    Storage::disk('public')->delete('images/' . $trainer->image);
                }

                // Save new image
                $filename = $request->file('image')->store('images', 'public');
                $trainer->image = basename($filename);
            }
            $trainer->save();
        }

        if ($request->role === 'member') {
            $membership = Membership::findOrFail($request->membership_id);
            $startDate = Carbon::parse($request->start_date);
            $endDate = $startDate->addMonths($membership->duration);

            $member = Member::firstOrNew(['email' => $user->email]);
            $member->user_id = $user->id;
            $member->name = $user->name;
            $member->email = $user->email;
            $member->phone = $user->phone_number;
            $member->membership_id = $request->membership_id;
            $member->start_date = $request->start_date;
            $member->end_date = $endDate;
            $member->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully!',
            'redirect_url' => route('admin.users.index')
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->role === 'trainer') {
            Trainer::where('email', $user->email)->delete();
        }
        if ($user->role === 'member') {
            Member::where('email', $user->email)->delete();
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User Deleted successfully.');
    }


}
