@extends('admin.layout')

@section('content')
    <div class="services">
        <h1>Manage Services</h1>
        <a href="{{ route('admin.services.create') }}" class="button">Add New Service</a>

        <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>
                            @if($service->image)
                                <img src="{{ asset('storage/images/' . $service->image) }}" alt="Service Image" width="100">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->description }}</td>
                        <td>
                            <div class="buttons">
                                <a href="{{ route('admin.services.edit', $service) }}" class="button">Edit</a>

                                <!-- Delete Form with SweetAlert2 Confirmation -->
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" id="delete-form-{{ $service->id }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="button danger" data-id="{{ $service->id }}" id="delete-btn-{{ $service->id }}">Delete</button>
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
            // Confirm before deleting Service entry
            $('button[id^="delete-btn-"]').on('click', function () {
                var serviceId = $(this).data('id');
                var formId = '#delete-form-' + serviceId;

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
