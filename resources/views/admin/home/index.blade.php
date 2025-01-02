@extends('admin.layout')

@section('content')
    <div class="users">
        <h1>Manage Home</h1>
        <a href="{{ route('admin.home.create') }}" class="button">Add New Class</a>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Operating Hours</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($homes as $home)
                        <tr>
                            <td>{{ $home->id }}</td>
                            <td>
                                @if($home->background_image)
                                    <img src="{{ asset('storage/' . $home->background_image) }}" alt="{{ $home->title }}" width="100">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>{{ $home->title }}</td>
                            <td>{{ $home->description }}</td>
                            <td>{{ $home->operating_hours }}</td>
                            <td>
                                <div class="buttons">
                                    <a href="{{ route('admin.home.edit', $home->id) }}" class="button">Edit</a>

                                    <!-- Delete Form with SweetAlert2 Confirmation -->
                                    <form action="{{ route('admin.home.destroy', $home->id) }}" method="POST" id="delete-form-{{ $home->id }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="button danger" data-id="{{ $home->id }}" id="delete-btn-{{ $home->id }}">Delete</button>
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
            // Confirm before deleting Home entry
            $('button[id^="delete-btn-"]').on('click', function () {
                var homeId = $(this).data('id');
                var formId = '#delete-form-' + homeId;

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
