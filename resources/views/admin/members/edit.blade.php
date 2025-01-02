@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Edit Member</h1>

        <form action="{{ route('admin.members.update', $member->id) }}" method="POST" id="member-edit-form">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ $member->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $member->email }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ $member->phone }}" required>
            </div>

            <div class="form-group">
                <label for="membership_id">Membership Plan</label>
                <select name="membership_id" id="membership_id" onchange="updateEndDate()">
                    <option value="">Select Plan</option>
                    @foreach ($memberships as $membership)
                        <option value="{{ $membership->id }}"
                            data-type="{{ $membership->type }}"
                            data-duration="{{ $membership->duration }}"
                            {{ $member->membership_id == $membership->id ? 'selected' : '' }}>
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
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $member->start_date) }}"
                       onchange="updateEndDate()" required>
                @error('start_date')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $member->end_date) }}">
                @error('end_date')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="button">Update Member</button>
        </form>
    </div>

    @push('scripts')
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function () {
                let initialData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    membership_id: $('#membership_id').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                };

                // Submit the form using AJAX
                $('#member-edit-form').on('submit', function (e) {
                    e.preventDefault();

                    let formData = $(this).serialize(); // Use serialize to collect form data
                    let hasChanges = false;

                    // Check if any field has changed
                    if ($('#name').val() !== initialData.name ||
                        $('#email').val() !== initialData.email ||
                        $('#phone').val() !== initialData.phone ||
                        $('#membership_id').val() !== initialData.membership_id ||
                        $('#start_date').val() !== initialData.start_date ||
                        $('#end_date').val() !== initialData.end_date) {
                        hasChanges = true;
                    }

                    if (hasChanges) {
                        $.ajax({
                            url: '{{ route("admin.members.update", ":id") }}'.replace(':id', {{ $member->id }}), // Use the member's ID for routing
                            method: 'POST',
                            data: formData,
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = response.redirect_url; // Redirect after success
                                        }
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while updating the member.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'No Changes!',
                            text: 'No changes were made to the member.',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("admin.memberships.index") }}'; // Redirect to index
                        }
                    });
                    }
                });
            });
        </script>
    @endpush
@endsection
