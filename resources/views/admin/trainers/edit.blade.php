@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Edit Trainer</h1>

        <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST" enctype="multipart/form-data" id="trainer-edit-form">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ $trainer->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $trainer->email }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ $trainer->phone }}" required>
            </div>
            <div class="form-group">
                <label for="specialization">Specialization</label>
                <input type="text" name="specialization" id="specialization" value="{{ $trainer->specialization }}" required>
            </div>
            <div class="form-group">
                <label for="bio">Bio</label><br>
                <textarea name="bio" id="bio">{{ $trainer->bio }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                @if($trainer && $trainer->image)
                    <div>
                        <p>Current Image:</p>
                        <img src="{{ asset('storage/images/' . $trainer->image) }}" alt="{{ $trainer->name }}" width="150">
                    </div>
                @endif
                <input type="file" name="image" id="image">
            </div>

            <button type="submit" class="button">Update Trainer</button>
        </form>
    </div>

    @push('scripts')
        <script src="{{asset('js/scripts.js')}}"></script>
        <script src="{{asset('js/jquery-3.7.0.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                // Track initial data before the form is edited
                let initialData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    specialization: $('#specialization').val(),
                    bio: $('#bio').val(),
                    image: $('#image').val(), // Track if image has been changed
                };

                // Submit the form using AJAX
                $('#trainer-edit-form').on('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData(this); // Use FormData for file uploads
                    let hasChanges = false;

                    // Check if any field has changed
                    if ($('#name').val() !== initialData.name ||
                        $('#email').val() !== initialData.email ||
                        $('#phone').val() !== initialData.phone ||
                        $('#specialization').val() !== initialData.specialization ||
                        $('#bio').val() !== initialData.bio ||
                        $('#image').val() !== initialData.image) {
                        hasChanges = true;
                    }

                    if (hasChanges) {
                        $.ajax({
                            url: '{{ route("admin.trainers.update", ":id") }}'.replace(':id', {{ $trainer->id }}), // Use the trainer's ID for routing
                            method: 'POST',
                            data: formData,
                            processData: false, // Required for file uploads
                            contentType: false, // Required for file uploads
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
                                            // Redirect to the trainer's index page after successful update
                                            window.location.href = response.redirect_url;
                                        }
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while updating the trainer.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    } else {
                        // If nothing changed, show SweetAlert message
                        Swal.fire({
                            title: 'No Changes!',
                            text: 'No changes were made to the trainer.',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("admin.footer.index") }}'; // Redirect to index
                        }
                    });
                    }
                });
            });
        </script>
    @endpush
@endsection
