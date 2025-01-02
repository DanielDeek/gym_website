@extends('admin.layout')

@section('content')
    <div class="users">
        <h1>Manage Users</h1>
        <a href="{{route('admin.users.create')}}" class="button">Add New User</a>

        <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through users -->
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone_number}}</td>
                        <td>{{$user->role}}</td>
                        <td>
                            <div class="buttons">
                                <a href="{{route('admin.users.edit',$user->id)}}" class="button">Edit</a>

                                <!-- Delete Form with SweetAlert2 Confirmation -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="delete-form-{{ $user->id }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="button danger" data-id="{{ $user->id }}" id="delete-btn-{{ $user->id }}">Delete</button>
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
            // Confirm before deleting User entry
            $('button[id^="delete-btn-"]').on('click', function () {
                var userId = $(this).data('id');
                var formId = '#delete-form-' + userId;

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
