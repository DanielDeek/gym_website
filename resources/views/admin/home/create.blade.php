@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Add New HomeContent</h1>

        <form action="{{ route('admin.home.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="background_image">Background Image</label>
                <input type="file" name="background_image" id="background_image" accept=".jpeg,.png,.jpg,.gif,.svg">
                @error('background_image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label><br>
                <textarea name="description" id="description">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="operating_hours">Operating Hours</label><br>
                <textarea name="operating_hours" id="operating_hours">{{ old('operating_hours') }}</textarea>
                @error('operating_hours')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="button">Create HomeContent</button>
        </form>

    </div>
@endsection
