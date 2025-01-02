@extends('layout')

@section('title', 'Login')

@section('content')
<div class="login-page">
    <div class="login-container">
        <!-- Left Section: Welcome Back Message -->
        <div class="login-welcome">
            <h1>Welcome Back to <span> Gym</span></h1>
            <p>Your fitness journey continues here. Log in to access your personalized dashboard, classes, and more.</p>
            <img src="{{asset('images/personaltrainer.png')}}" alt="Fitness Inspiration">
        </div>

        <!-- Right Section: Login Form -->
        <div class="login-form">
            <h2>Login to Your Account</h2>
            <form action="{{route('login.post')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    @error('email')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    @error('password')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="submit-btn">Login</button>
            </form>
            <p class="login-text">Don't have an account? <a href="{{ route('register') }}" class="login-link">Register here</a></p>
            <p class="login-text"><a href="" class="login-link">Forgot your password?</a></p>
        </div>
    </div>
</div>

@endsection
