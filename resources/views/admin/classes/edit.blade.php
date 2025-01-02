@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Edit Class</h1>

        <form id="class-edit-form" action="{{ route('admin.classes.update', $class->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="class_name">Class Name</label>
                <input type="text" name="class_name" id="class_name" value="{{ $class->class_name }}" required>
                @error('class_name')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label><br>
                <textarea name="description" id="description">{{$class->description}}</textarea>
                @error('description')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="trainer_id">Trainer</label>
                <select name="trainer_id" id="trainer_id">
                    <option value="">Select Trainer</option>
                    @foreach ($trainers as $trainer)
                        <option value="{{ $trainer->id }}" {{ $trainer->id == $class->trainer_id ? 'selected' : '' }}>
                            {{ $trainer->name }}
                        </option>
                    @endforeach
                </select>
                @error('trainer_id')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" id="start_time" value="{{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }}" required>
                @error('start_time')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" name="end_time" id="end_time" value="{{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}" required>
                @error('end_time')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="day_of_week">Days of Week</label>
                <input type="text" name="day_of_week" id="day_of_week" value="{{ $class->day_of_week }}" required>
                @error('day_of_week')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" value="{{ $class->price }}" required>
                @error('price')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                @if($class->image)
                    <div>
                        <p>Current Image:</p>
                        <img src="{{ asset('storage/images/' . $class->image) }}" alt="{{ $class->class_name }}" width="150">
                    </div>
                @else
                    <p>No Image Available</p>
                @endif
                <input type="file" name="image" id="image">
            </div>

            <button type="submit" class="button">Update Class</button>
        </form>
    </div>

    <!-- Include the SweetAlert2 and jQuery -->
    <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            let initialData = {
                class_name: $('#class_name').val(),
                description: $('#description').val(),
                trainer_id: $('#trainer_id').val(),
                start_time: $('#start_time').val(),
                end_time: $('#end_time').val(),
                day_of_week: $('#day_of_week').val(),
                price: $('#price').val(),
                image: $('#image').val() // Include image input value (though image changes are handled separately)
            };

            // Submit the form using AJAX
            $('#class-edit-form').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this); // Use FormData to handle file uploads
                let hasChanges = false;

                // Check if any field has changed
                if ($('#class_name').val() !== initialData.class_name ||
                    $('#description').val() !== initialData.description ||
                    $('#trainer_id').val() !== initialData.trainer_id ||
                    $('#start_time').val() !== initialData.start_time ||
                    $('#end_time').val() !== initialData.end_time ||
                    $('#day_of_week').val() !== initialData.day_of_week ||
                    $('#status').val() !== initialData.status ||
                    $('#price').val() !== initialData.price ||
                    $('#image').val() !== initialData.image) {
                    hasChanges = true;
                }

                if (hasChanges) {
                    $.ajax({
                        url: '{{ route("admin.classes.update", ":id") }}'.replace(':id', {{ $class->id }}), // Use the class's ID for routing
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
                                text: 'An error occurred while updating the class.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'No Changes!',
                        text: 'No changes were made to the class.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("admin.classes.index") }}'; // Redirect to index
                        }
                    });
                }
            });
        });
    </script>
@endsection
