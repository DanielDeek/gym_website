<?php

namespace App\Http\Controllers;

use App\Models\Classs;
use App\Models\Member;
use App\Models\MemberClass;
use App\Models\Trainer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $totalUsers = User::count();
        $totalTrainers = Trainer::count();
        $totalActiveMembers = Member::where('status','active')->count();
        $totalClasses = Classs::where('status','active')->count();
        $totalclassmembers = MemberClass::count();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $membersThisMonth = Member::whereMonth('start_date', $currentMonth)
            ->whereYear('start_date', $currentYear)
            ->orWhere(function ($query) use ($currentMonth, $currentYear) {
                $query->whereMonth('end_date', $currentMonth)
                      ->whereYear('end_date', $currentYear);
            })
            ->get();

        $totalRevenue = $membersThisMonth->sum(function ($member) {
            return $member->membership->price;  // Assuming 'price' is a field on the membership model
        });

        
        return view('admin.dashboard',compact('totalUsers','totalTrainers','totalActiveMembers','totalClasses','totalclassmembers','totalRevenue'));
    }
}
