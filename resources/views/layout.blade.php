<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Gym Website')</title>
    <link rel="icon" href="{{ asset('images/background.png') }}" type="image/png">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav id="navbar">
        <div class="logo">
            <h3>Gym</h3>
        </div>
        <div class="menu">
            <ul>
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('classes')}}">Classes</a></li>
                <li><a href="{{route('pricing')}}">Pricing</a></li>
                <li><a href="{{route('contactus')}}">Contact Us</a></li>
            </ul>
        </div>

        @auth
            <div class="logged-in">
                <div class="user-dropdown">
                    <button class="dropdown-toggle">
                        Welcome, {{ Auth::user()->name }} <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('change-password')}}">Change Password</a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               Logout
                            </a>
                        </li>
                    </ul>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @else
            <div class="join-us">
                <a href="{{route('register')}}">Register</a>
                <a href="{{route('login')}}">Login</a>
            </div>
        @endauth

        <!-- Hamburger Icon -->
        <div class="hamburger" id="hamburger-icon">
            <i class="fas fa-bars"></i>
        </div>
    </nav>

    <div class="content">
        @yield('content')
    </div>

    <footer class="footer">
        @isset ($footer)
        <div class="footer-container">
            <!-- Footer Logo and Description -->
            <div class="footer-logo">
                <h2>Gym</h2>
                <p>{{$footer->description}}</p>
            </div>
        @endisset
            <!-- Quick Links -->
            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li><a href="{{route('classes')}}">Classes</a></li>
                    <li><a href="{{route('pricing')}}">Pricing</a></li>
                    <li><a href="{{route('contactus')}}">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Information -->
            @isset ($footer)
            <div class="footer-contact">
                <h3>Contact Us</h3>
                <p>Address: {{$footer->address}}</p>
                <p>Email: <a href="mailto:{{$footer->email}}">{{$footer->email}}</a></p>
                <p>Phone: <a href="tel:{{$footer->phone}}">{{$footer->phone}}</a></p>
            </div>
            @endisset
            <!-- Social Media Links -->
            <div class="footer-social">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>


        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2024 Gym. All Rights Reserved.</p>
        </div>
    </footer>
    <script>
        const hamburger = document.getElementById('hamburger-icon');
        const menu = document.querySelector('.menu');

        hamburger.addEventListener('click', () => {
            menu.classList.toggle('active');
        });

        // User Dropdown Toggle
        const userDropdown = document.querySelector('.user-dropdown');
        const dropdownToggle = document.querySelector('.dropdown-toggle');

        dropdownToggle.addEventListener('click', (e) => {
            e.preventDefault();
            userDropdown.classList.toggle('active');
        });
    </script>
</body>
</html>
