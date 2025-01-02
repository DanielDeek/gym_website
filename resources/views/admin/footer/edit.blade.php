@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Edit Footer</h1>

        <form id="footer-edit-form" action="{{ route('admin.footer.update', $footer->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="description">Description</label><br>
                <textarea name="description" id="description">{{ $footer->description }}</textarea>
                @error('description')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">Address</label><br>
                <input type="text" name="address" id="address" value="{{$footer->address}}">
                @error('address')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $footer->email }}">
                @error('email')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ $footer->phone }}">
                @error('phone')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="button">Update Footer</button>
        </form>
    </div>

    <!-- Include the SweetAlert2 and jQuery -->
    <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            let initialData = {
                description: $('#description').val(),
                address: $('#address').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
            };

            // Submit the form using AJAX
            $('#footer-edit-form').on('submit', function (e) {
                e.preventDefault();

                let formData = $(this).serialize(); // Serialize form data for non-file inputs
                let hasChanges = false;

                // Check if any field has changed
                if ($('#description').val() !== initialData.description ||
                    $('#address').val() !== initialData.address ||
                    $('#email').val() !== initialData.email ||
                    $('#phone').val() !== initialData.phone) {
                    hasChanges = true;
                }

                if (hasChanges) {
                    $.ajax({
                        url: '{{ route("admin.footer.update", ":id") }}'.replace(':id', {{ $footer->id }}), // Use the ID for routing
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
                                text: 'An error occurred while updating the footer.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'No Changes!',
                        text: 'No changes were made to the footer.',
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
@endsection
