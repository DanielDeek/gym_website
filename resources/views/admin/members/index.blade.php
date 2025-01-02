@extends('admin.layout')

@section('content')
    <div class="users">
        <h1>Manage Members</h1>
        <a href="{{ route('admin.members.create') }}" class="button">Add New Member</a>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Membership Plan</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>{{ $member->membership->type }}</td>
                            <td>{{ $member->start_date }}</td>
                            <td>{{ $member->end_date }}</td>
                            <td>{{ $member->status }}</td>
                            <td>
                                <div class="buttons">
                                    <a href="{{ route('admin.members.edit', $member->id) }}" class="button">Edit</a>

                                    <!-- Delete Form with SweetAlert2 Confirmation -->
                                    <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" id="delete-form-{{ $member->id }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="button danger" data-id="{{ $member->id }}" id="delete-btn-{{ $member->id }}">Delete</button>
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
            // Confirm before deleting Member entry
            $('button[id^="delete-btn-"]').on('click', function () {
                var memberId = $(this).data('id');
                var formId = '#delete-form-' + memberId;

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
