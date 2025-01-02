@extends('layout')

@section('title', 'Register')

@section('content')
<div class="register-page">
    <div class="register-container">
        <div class="register-welcome">
            <h1>Join <span> Gym</span></h1>
            <p>Start your fitness journey with us today. Sign up and unlock access to the best equipment, classes, and trainers in the industry!</p>
            <img src="{{asset('images/personaltrainer.png')}}" alt="Fitness Inspiration">
        </div>

        <div class="register-form">
            <h2>Create Your Account</h2>
            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                    @error('password')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                    @error('password_confirmation')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">Register</button>
            </form>
            <p class="login-text">Already a member? <a href="{{ route('login') }}" class="login-link">Login here</a></p>
        </div>
    </div>
</div>
@endsection
