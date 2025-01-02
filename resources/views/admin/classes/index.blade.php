@extends('admin.layout')

@section('content')
    <div class="users">
        <h1>Manage Classes</h1>
        <a href="{{route('admin.classes.create')}}" class="button">Add New Class</a>
        <a href="{{route('admin.memberClass.index')}}" class="button">Show Members</a>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Class Name</th>
                        <th>Description</th>
                        <th>Trainer</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Day of Week</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $class)
                        <tr>
                            <td>{{$class->id}}</td>
                            <td>{{$class->class_name}}</td>
                            <td>{{$class->description}}</td>
                            <td>{{$class->trainer->name}}</td>
                            <td>{{ \Carbon\Carbon::parse($class->start_time)->format('h:i a') }}</td>  <!-- 12-hour format -->
                            <td>{{ \Carbon\Carbon::parse($class->end_time)->format('h:i a') }}</td>    <!-- 12-hour format -->
                            <td>{{$class->day_of_week}}</td>
                            <td>${{$class->price}}/Month</td>
                            <td>
                                @if($class->image)
                                    <img src="{{ asset('storage/images/' . $class->image) }}" alt="Service Image" width="100">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                <div class="buttons">
                                    <a href="{{route('admin.classes.edit',$class->id)}}" class="button">Edit</a>

                                    <!-- Delete Form with SweetAlert Confirmation -->
                                    <form action="{{route('admin.classes.destroy',$class->id)}}" method="POST" id="delete-form-{{ $class->id }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="button danger" data-id="{{ $class->id }}" id="delete-btn-{{ $class->id }}">Delete</button>
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
            // Confirm before deleting Class
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
