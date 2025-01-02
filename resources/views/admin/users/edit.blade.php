@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Edit User</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="user-edit-form">
            @csrf
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                    <option value="trainer" {{ $user->role === 'trainer' ? 'selected' : '' }}>Trainer</option>
                    <option value="guest" {{ $user->role === 'guest' ? 'selected' : '' }}>Guest</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ $user->phone_number }}">
            </div>


            <div id="trainer-fields" style="display: none;">
                <div class="form-group">
                    <label for="specialization">Specialization</label>
                    <input type="text" name="specialization" id="specialization"
                        value="{{ $trainer->specialization ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label><br>
                    <textarea name="bio" id="bio">{{ $trainer->bio ?? '' }}</textarea>
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





            <div id="member-fields" style="display: none;">
                <div class="form-group">
                    <label for="membership_id">Membership Plan</label>
                    <select name="membership_id" id="membership_id">
                        <option value="">Select Plan</option>
                        @foreach ($memberships as $membership)
                            <option value="{{ $membership->id }}" data-duration="{{ $membership->duration }}"
                                {{ $member && $member->membership_id == $membership->id ? 'selected' : '' }}>
                                {{ $membership->type }} ({{ $membership->duration }} months)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $member->start_date ?? '' }}"
                        onchange="updateEndDate()">
                </div>

                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $member->end_date ?? '' }}" readonly>
                </div>
            </div>

            <button type="submit" class="button">Update User</button>
        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trainerFields = document.getElementById('trainer-fields');
            const memberFields = document.getElementById('member-fields');
            const roleDropdown = document.getElementById('role');

            const toggleFields = () => {
                if (roleDropdown.value === 'trainer') {
                    trainerFields.style.display = 'block';
                    memberFields.style.display = 'none';
                } else if (roleDropdown.value === 'member') {
                    memberFields.style.display = 'block';
                    trainerFields.style.display = 'none';
                } else {
                    trainerFields.style.display = 'none';
                    memberFields.style.display = 'none';
                }
            };

            toggleFields();
            roleDropdown.addEventListener('change', toggleFields);
        });
    </script>
    @push('scripts')
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{asset('js/jquery-3.7.0.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                // Track initial data before the form is edited
                let initialData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone_number: $('#phone_number').val(),
                    role: $('#role').val(),
                    password: $('#password').val(),
                };

                // AJAX request to update an existing user
                $('#user-edit-form').on('submit', function(e) {
                    e.preventDefault();

                    let formData = $(this).serialize();
                    let hasChanges = false;

                    // Check if the form data has changed
                    if ($('#name').val() !== initialData.name ||
                        $('#email').val() !== initialData.email ||
                        $('#phone_number').val() !== initialData.phone_number ||
                        $('#role').val() !== initialData.role ||
                        $('#password').val() !== initialData.password) {
                        hasChanges = true;
                    }

                    if (hasChanges) {
                        $.ajax({
                            url: '{{ route("admin.users.update", ":id") }}'.replace(':id', {{ $user->id }}), // Update with the user's ID
                            method: 'POST',
                            data: formData,
                            success: function(response) {
                                if (response.status === 'success') {
                                    // Show SweetAlert success message
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Redirect to the users index page
                                            window.location.href = response.redirect_url;
                                        }
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while updating the user.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    } else {
                        // If nothing changed, show SweetAlert with a message
                        Swal.fire({
                            title: 'No Changes!',
                            text: 'No changes were made to the user.',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route("admin.users.index") }}'; // Redirect to index
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
