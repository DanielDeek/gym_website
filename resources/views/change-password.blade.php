@extends('layout')

@section('title', 'Change Password')

@section('content')
    <!-- Change Password Page -->
    <div id="change-password" class="change-password-section">
        <div class="container">
            <h2>Change Password</h2>
            <p>To keep your account secure, please update your password below.</p>

            <!-- Change Password Form -->
            <div class="change-password-form">
                <h3>Update Your Password</h3>
                <form action="{{route('change-password')}}" method="POST">
                    @csrf

                    <!-- Current Password -->
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required placeholder="Enter your current password">
                        @error('current_password')
                            <span>{{$message}}</span>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required placeholder="Enter your new password">
                        @error('new_password')
                            <span>{{$message}}</span>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required placeholder="Confirm your new password">
                        @error('new_password_confirmation')
                            <span>{{$message}}</span>
                        @enderror
                    </div>

                    <button type="submit" class="cta-button">Confirm Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
