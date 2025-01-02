@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Edit About Us</h1>

        <form id="about-us-edit-form" action="{{ route('admin.about-us.update', $about->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="description">Description</label><br>
                <textarea name="description" id="description">{{ $about->description }}</textarea>
                @error('description')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="philosophy_description">Philosophy Description</label><br>
                <textarea name="philosophy_description" id="philosophy_description">{{ $about->philosophy_description }}</textarea>
                @error('philosophy_description')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                @if($about->image)
                    <div>
                        <p>Current Image:</p>
                        <img src="{{ asset('storage/' . $about->image) }}" alt="About Image" width="150">
                    </div>
                @else
                    <p>No Image Available</p>
                @endif
                <input type="file" name="image" id="image">
                @error('image')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="button">Update About Us</button>
        </form>
    </div>

    <!-- Include the SweetAlert2 and jQuery -->
    <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            let initialData = {
                description: $('#description').val(),
                philosophy_description: $('#philosophy_description').val(),
                image: $('#image').val() // Include image input value (though image changes are handled separately)
            };

            // Submit the form using AJAX
            $('#about-us-edit-form').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this); // Use FormData to handle file uploads
                let hasChanges = false;

                // Check if any field has changed
                if ($('#description').val() !== initialData.description ||
                    $('#philosophy_description').val() !== initialData.philosophy_description ||
                    $('#image').val() !== initialData.image) {
                    hasChanges = true;
                }

                if (hasChanges) {
                    $.ajax({
                        url: '{{ route("admin.about-us.update", ":id") }}'.replace(':id', {{ $about->id }}), // Use the ID for routing
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
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
                                text: 'An error occurred while updating About Us.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'No Changes!',
                        text: 'No changes were made to About Us.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("admin.about-us.index") }}'; // Redirect to index
                        }
                    });
                }
            });
        });
    </script>
@endsection
