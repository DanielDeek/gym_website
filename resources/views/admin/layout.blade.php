<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="icon" href="{{ asset('images/background.png') }}" type="image/png">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="{{route('admin.dashboard')}}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                <li><a href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> <span>Home</span></a></li>
                <li><a href="{{route('admin.about-us.index')}}"><i class="fas fa-info-circle"></i> <span>About</span></a></li>
                <li><a href="{{route('admin.footer.index')}}"><i class="fas fa-shoe-prints"></i> <span>Footer</span></a></li>
                <li><a href="{{route('admin.users.index')}}"><i class="fas fa-users"></i> <span>Users</span></a></li>
                <li><a href="{{route('admin.trainers.index')}}"><i class="fas fa-dumbbell"></i> <span>Trainers</span></a></li>
                <li><a href="{{route('admin.memberships.index')}}"><i class="fas fa-id-card"></i> <span>Membership Plans</span></a></li>
                <li><a href="{{route('admin.members.index')}}"><i class="fas fa-user"></i> <span>Members</span></a></li>
                <li><a href="{{route('admin.classes.index')}}"><i class="fas fa-calendar-alt"></i> <span>Classes</span></a></li>
                <li><a href="{{route('admin.services.index')}}"><i class="fas fa-concierge-bell"></i> <span>Services</span></a></li>
                <li><a href="{{route('admin.contacts.index')}}"><i class="fas fa-envelope"></i> <span>Contacts</span></a></li>
                <li><a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="content">
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>
