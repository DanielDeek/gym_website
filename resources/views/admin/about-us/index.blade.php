@extends('admin.layout')

@section('content')
    <div class="users">
        <h1>Manage About Us</h1>
        <a href="{{route('admin.about-us.create')}}" class="button">Add New About Us</a>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Philosophy Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($abouts as $about)
                        <tr>
                            <td>{{$about->id}}</td>
                            <td>{{$about->description}}</td>
                            <td>{{$about->philosophy_description}}</td>
                            <td>
                                @if($about->image)
                                    <img src="{{ asset('storage/' . $about->image) }}" alt="About Image" width="100">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                <div class="buttons">
                                    <a href="{{route('admin.about-us.edit',$about->id)}}" class="button">Edit</a>

                                    <!-- Delete Form with SweetAlert Confirmation -->
                                    <form action="{{route('admin.about-us.destroy',$about->id)}}" method="POST" id="delete-form-{{ $about->id }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="button danger" data-id="{{ $about->id }}" id="delete-btn-{{ $about->id }}">Delete</button>
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
            // Confirm before deleting About Us section
            $('button[id^="delete-btn-"]').on('click', function () {
                var aboutId = $(this).data('id');
                var formId = '#delete-form-' + aboutId;

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
