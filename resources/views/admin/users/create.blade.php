@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Add New User</h1>

        <form action="{{ route('admin.users.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role">
                    <option value="">Select Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>Trainer</option>
                    <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
                    <option value="guest" {{ old('role') == 'guest' ? 'selected' : '' }}>Guest</option>
                </select>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone_number">Phone</label>
                <input type="text" name="phone_number" id="phone_number" value="{{old('phone_number')}}">
                @error('phone')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group password-form">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                @error('password')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group password-form">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation">
            </div>

            <!-- Trainer Fields -->
            <div id="trainer-fields" style="display: none;">
                <div class="form-group">
                    <label for="specialization">Specialization</label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $trainer->specialization ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label><br>
                    <textarea name="bio" id="bio">{{ old('bio', $trainer->bio ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    @if($trainer && $trainer->image)
                        <div>
                            <p>Current Image:</p>
                            <img src="{{ asset('storage/images/' . $trainer->image) }}" alt="{{ $trainer->name ?? 'Trainer' }}" width="150">
                        </div>
                    @else
                        <p>No Image Available</p>
                    @endif
                    <input type="file" name="image" id="image">
                </div>
            </div>

            {{-- Member Fields --}}
            <div id="member-fields" style="display: none;">
                <div class="form-group">
                    <label for="membership_id">Membership Plan</label>
                    <select name="membership_id" id="membership_id" onchange="updateEndDate()">
                        <option value="">Select Plan</option>
                        @foreach ($memberships as $membership)
                            <option value="{{ $membership->id }}" data-type="{{ $membership->type }}"
                                data-duration="{{ $membership->duration }}">
                                {{ $membership->type }} ({{ $membership->duration }} months)
                            </option>
                        @endforeach
                    </select>
                    @error('membership_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        onchange="updateEndDate()" >
                    @error('start_date')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}">
                    @error('end_date')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="button">Create User</button>
        </form>
    </div>

    <script>
        // Toggle trainer-specific fields based on selected role
        document.getElementById('role').addEventListener('change', function() {
            const trainerFields = document.getElementById('trainer-fields');
            const memberFields = document.getElementById('member-fields');
            const passwordFields = document.querySelectorAll('.password-form');

            // Reset all fields visibility
            trainerFields.style.display = 'none';
            memberFields.style.display = 'none';
            passwordFields.forEach(field => field.style.display = 'block'); // Make sure password fields are visible

            if (this.value === 'trainer') {
                trainerFields.style.display = 'block';
                passwordFields.forEach(field => field.style.display = 'none'); // Hide password fields for trainer
            }

            if (this.value === 'member') {
                memberFields.style.display = 'block';
                passwordFields.forEach(field => field.style.display = 'none'); // Hide password fields for member
            }
        });
    </script>
    @push('scripts')
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('js/jquery-3.7.0.js')}}"></script>
    @endpush
@endsection
