@extends('admin.layout')

@section('content')
    <div class="dashboard">
        <h1>Welcome to the Admin Dashboard</h1>

        <!-- Stats Section -->
        <div class="stats">
            <a href="{{route('admin.users.index')}}">
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <p>{{$totalUsers}}</p>
                </div>
            </a>

            <a href="{{route('admin.trainers.index')}}">
                <div class="stat-card">
                    <h3>Total Trainers</h3>
                    <p>{{$totalTrainers}}</p>
                </div>
            </a>

            <a href="{{route('admin.members.index')}}">
                <div class="stat-card">
                    <h3>Active Members</h3>
                    <p>{{$totalActiveMembers}}</p>
                </div>
            </a>

            <a href="{{route('admin.classes.index')}}">
                <div class="stat-card">
                    <h3>Classes Scheduled</h3>
                    <p>{{$totalClasses}}</p>
                </div>
            </a>

            <a href="{{route('admin.memberClass.index')}}">
                <div class="stat-card">
                    <h3>Members in Classes</h3>
                    <p>{{$totalclassmembers}}</p>
                </div>
            </a>

            <div class="stat-card">
                <h3>Total Revenue for This Month</h3>
                <p>${{ number_format($totalRevenue, 2) }}</p>
            </div>



        </div>
    </div>
@endsection
