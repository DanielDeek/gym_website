@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Edit Member</h1>

        <form id="class-edit-form" action="{{ route('admin.memberClass.update', $memberClass->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ $memberClass->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $memberClass->email }}">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="{{ $memberClass->phone }}">
            </div>

            <div class="form-group">
                <label for="class_id">Class</label>
                <select id="class_id" name="class_id" required>
                    <option value="">Select a class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ $class->id == $memberClass->class_id ? 'selected' : '' }}>{{ $class->class_name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="button">Update Class</button>
        </form>
    </div>

    <!-- Include jQuery and SweetAlert2 -->
    <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Listen for form submission
            $('#class-edit-form').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                // Create a FormData object to handle file uploads (if any)
                var formData = new FormData(this);

                // Make AJAX request to submit the form
                $.ajax({
                    url: $(this).attr('action'), // Use the form's action URL
                    method: 'POST',
                    data: formData,
                    processData: false,  // Prevent jQuery from trying to process the data
                    contentType: false,  // Let the browser set the content type for file uploads
                    success: function (response) {
                        // Display SweetAlert2 on success
                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'Class updated successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to the member class index page after successful update
                                window.location.href = response.redirect_url || '{{ route("admin.memberClass.index") }}';
                            }
                        });
                    },
                    error: function (xhr) {
                        // Display SweetAlert2 on error
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while updating the class.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endsection
