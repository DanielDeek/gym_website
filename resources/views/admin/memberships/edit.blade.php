@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Edit Membership</h1>

        <form id="membership-edit-form" action="{{ route('admin.memberships.update', $membership->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" value="{{ $membership->type }}" required>
                @error('type')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" value="{{ $membership->price }}" required>
                @error('price')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="number" name="duration" id="duration" value="{{ $membership->duration }}" required>
                @error('duration')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="benefits">Benefits</label><br>
                <textarea name="benefits" id="benefits" cols="30" rows="10">{{ $membership->benefits }}</textarea>
                @error('benefits')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="button">Update Membership</button>
        </form>
    </div>

    <!-- Include the SweetAlert2 and jQuery -->
    <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            let initialData = {
                type: $('#type').val(),
                price: $('#price').val(),
                duration: $('#duration').val(),
                benefits: $('#benefits').val(),
            };

            // Submit the form using AJAX
            $('#membership-edit-form').on('submit', function (e) {
                e.preventDefault();

                let formData = $(this).serialize(); // Serialize form data
                let hasChanges = false;

                // Check if any field has changed
                if ($('#type').val() !== initialData.type ||
                    $('#price').val() !== initialData.price ||
                    $('#duration').val() !== initialData.duration ||
                    $('#benefits').val() !== initialData.benefits) {
                    hasChanges = true;
                }

                if (hasChanges) {
                    $.ajax({
                        url: '{{ route("admin.memberships.update", ":id") }}'.replace(':id', {{ $membership->id }}),
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
                                text: 'An error occurred while updating the membership.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'No Changes!',
                        text: 'No changes were made to the membership.',
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
@endsection
