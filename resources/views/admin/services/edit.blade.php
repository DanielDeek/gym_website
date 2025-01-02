@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Edit Service</h1>

        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" id="service-edit-form">
            @csrf

            <div class="form-group">
                <label for="name">Service Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label><br>
                <textarea name="description" id="description" rows="4">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Service Image</label>
                @if($service->image)
                    <div>
                        <p>Current Image:</p>
                        <img src="{{ asset('storage/images/' . $service->image) }}" alt="Service Image" width="150">
                    </div>
                @endif
                <input type="file" name="image" id="image">
            </div>

            <button type="submit" class="button">Update Service</button>
        </form>
    </div>

    @push('scripts')
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                // Track initial data before the form is edited
                let initialData = {
                    name: $('#name').val(),
                    description: $('#description').val(),
                    image: $('#image').val(), // Track if image has been changed
                };

                // Submit the form using AJAX
                $('#service-edit-form').on('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData(this); // Use FormData for file uploads
                    let hasChanges = false;

                    // Check if any field has changed
                    if ($('#name').val() !== initialData.name ||
                        $('#description').val() !== initialData.description ||
                        $('#image').val() !== initialData.image) {
                        hasChanges = true;
                    }

                    if (hasChanges) {
                        $.ajax({
                            url: '{{ route("admin.services.update", ":id") }}'.replace(':id', {{ $service->id }}), // Use the service's ID for routing
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
                                            // Redirect to the service's index page after successful update
                                            window.location.href = response.redirect_url;
                                        }
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while updating the service.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    } else {
                        // If nothing changed, show SweetAlert message
                        Swal.fire({
                            title: 'No Changes!',
                            text: 'No changes were made to the service.',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("admin.services.index") }}'; // Redirect to index
                        }
                    });;
                    }
                });
            });
        </script>
    @endpush
@endsection
