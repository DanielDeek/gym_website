@extends('admin.layout')

@section('content')
    <div class="users">
        <h1>Manage Trainers</h1>
        <a href="{{ route('admin.trainers.create') }}" class="button">Add New Trainer</a>

        <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Specialization</th>
                    <th>Bio</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trainers as $trainer)
                    <tr>
                        <td>{{ $trainer->id }}</td>
                        <td>{{ $trainer->name }}</td>
                        <td>{{ $trainer->email }}</td>
                        <td>{{ $trainer->phone }}</td>
                        <td>{{ $trainer->specialization }}</td>
                        <td>{{ $trainer->bio }}</td>
                        <td>
                            @if($trainer->image)
                                <img src="{{ asset('storage/images/' . $trainer->image) }}" alt="{{ $trainer->name }}" width="100">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <div class="buttons">
                                <a href="{{ route('admin.trainers.edit', $trainer->id) }}" class="button">Edit</a>

                                <!-- Delete Form with SweetAlert2 Confirmation -->
                                <form action="{{ route('admin.trainers.destroy', $trainer->id) }}" method="POST" id="delete-form-{{ $trainer->id }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="button danger" data-id="{{ $trainer->id }}" id="delete-btn-{{ $trainer->id }}">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>

    </div>

    <!-- Include jQuery and SweetAlert2 -->
    <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Confirm before deleting Trainer entry
            $('button[id^="delete-btn-"]').on('click', function () {
                var trainerId = $(this).data('id');
                var formId = '#delete-form-' + trainerId;

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(formId).submit();  // Submit the form if confirmed
                    }
                });
            });
        });
    </script>
@endsection
