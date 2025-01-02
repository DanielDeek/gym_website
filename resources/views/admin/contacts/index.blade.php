@extends('admin.layout')

@section('content')
    <div class="users">
        <h1>Contact Messages</h1>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->message }}</td>
                            <td>
                                <div class="buttons">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="button">View</a>

                                    <!-- Delete Form with SweetAlert Confirmation -->
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" id="delete-form-{{ $contact->id }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="button danger" data-id="{{ $contact->id }}" id="delete-btn-{{ $contact->id }}">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No contact messages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $contacts->links() }}
    </div>

    <!-- Include jQuery and SweetAlert2 -->
    <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Confirm before deleting Contact Message
            $('button[id^="delete-btn-"]').on('click', function () {
                var contactId = $(this).data('id');
                var formId = '#delete-form-' + contactId;

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
