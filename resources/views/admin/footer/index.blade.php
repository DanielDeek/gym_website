@extends('admin.layout')

@section('content')
    <div class="users">
        <h1>Manage Footer</h1>
        <a href="{{ route('admin.footer.create') }}" class="button">Add New Footer</a>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($footers as $footer)
                        <tr>
                            <td>{{ $footer->id }}</td>
                            <td>{{ $footer->description }}</td>
                            <td>{{ $footer->address }}</td>
                            <td>{{ $footer->email }}</td>
                            <td>{{ $footer->phone }}</td>
                            <td>
                                <div class="buttons">
                                    <a href="{{ route('admin.footer.edit', $footer->id) }}" class="button">Edit</a>

                                    <!-- Delete Form with SweetAlert Confirmation -->
                                    <form action="{{ route('admin.footer.destroy', $footer->id) }}" method="POST" id="delete-form-{{ $footer->id }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="button danger" data-id="{{ $footer->id }}" id="delete-btn-{{ $footer->id }}">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No footer data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include jQuery and SweetAlert2 -->
    <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Confirm before deleting Footer entry
            $('button[id^="delete-btn-"]').on('click', function () {
                var footerId = $(this).data('id');
                var formId = '#delete-form-' + footerId;

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
