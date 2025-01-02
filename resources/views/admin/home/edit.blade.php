@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Edit HomeContent</h1>

        <form action="{{ route('admin.home.update',$home->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="background_image">Background Image</label>
                @if($home->background_image)
                    <div>
                        <p>Current Image:</p>
                        <img src="{{ asset('storage/' . $home->background_image) }}" alt="{{ $home->title }}" width="150">
                    </div>
                @else
                    <p>No Image Available</p>
                @endif
                <input type="file" name="background_image" id="background_image">
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ $home->title }}">
                @error('title')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label><br>
                <textarea name="description" id="description" >{{$home->description}}</textarea>
                @error('description')
                    <span>{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="operating_hours">Operating Hours</label><br>
                <textarea name="operating_hours" id="operating_hours" >{{$home->operating_hours}}</textarea>
                @error('operating_hours')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="button">Update HomeContent</button>
        </form>
    </div>
@endsection
