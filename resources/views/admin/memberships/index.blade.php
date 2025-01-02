@extends('admin.layout')

@section('content')
    <div class="users">
        <h1>Manage Memberships</h1>
        <a href="{{route('admin.memberships.create')}}" class="button">Add New Membership</a>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Benefits</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($memberships as $membership)
                        <tr>
                            <td>{{$membership->id}}</td>
                            <td>{{$membership->type}}</td>
                            <td>${{$membership->price}}</td>
                            <td>{{$membership->duration}}</td>
                            <td>{{$membership->benefits}}</td>
                            <td>
                                <div class="buttons">
                                    <a href="{{route('admin.memberships.edit',$membership->id)}}" class="button">Edit</a>

                                    <form action="{{route('admin.memberships.destroy',$membership->id)}}" method="POST" id="delete-form-{{ $membership->id }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="button danger" data-id="{{ $membership->id }}" id="delete-btn-{{ $membership->id }}">Delete</button>
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
            // Confirm before deleting membership
            $('button[id^="delete-btn-"]').on('click', function () {
                var membershipId = $(this).data('id');
                var formId = '#delete-form-' + membershipId;

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
