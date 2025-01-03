@extends('admin.layout')

@section('content')
    <div class="users">
        <h1>Manage Members</h1>
        <a href="{{route('admin.memberClass.create')}}" class="button">Add New Member</a>
        <form method="GET" action="{{ route('admin.memberClass.index') }}" class="search-form">
            <input type="text" name="search" placeholder="Search members in class..." value="{{ request('search') }}">
            <button type="submit" class="button">Search</button>
        </form>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Class</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($memberClasses as $memberClass)
                        <tr>
                            <td>{{ $memberClass->name }}</td>
                            <td>{{ $memberClass->email }}</td>
                            <td>{{ $memberClass->phone }}</td>
                            <td>{{ $memberClass->class->class_name }}</td>
                            <td>
                                <a href="{{ route('admin.memberClass.edit', $memberClass->id) }}" class="button">Edit</a>

                                <form id="delete-form-{{ $memberClass->id }}" action="{{ route('admin.memberClass.destroy', $memberClass->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="button danger" id="delete-btn-{{ $memberClass->id }}" data-id="{{ $memberClass->id }}">Delete</button>
                                </form>
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
            // Confirm before deleting member class
            $('button[id^="delete-btn-"]').on('click', function () {
                var classId = $(this).data('id');
                var formId = '#delete-form-' + classId;

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
