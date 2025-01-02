@extends('admin.layout')

@section('content')
    <h2>Add New Service</h2>

    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Service Name</label>
            <input type="text" name="name" id="name" required>
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label><br>
            <textarea name="description" id="description" rows="4"></textarea>
            @error('description')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Service Image</label>
            <input type="file" name="image" id="image">
            @error('image')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="button">Create Service</button>
    </form>
@endsection
