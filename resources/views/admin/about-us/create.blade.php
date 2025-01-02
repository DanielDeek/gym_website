@extends('admin.layout')

@section('content')
<div class="form-container">
    <h1>Add New About Us</h1>

    <form action="{{ route('admin.about-us.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="description">Description</label><br>
            <textarea name="description" id="description"></textarea>
        </div>

        <div class="form-group">
            <label for="philosophy_description">Philosophy Description</label><br>
            <textarea name="philosophy_description" id="philosophy_description"></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image">
        </div>
        <button type="submit" class="button">Add About Us</button>
    </form>
</div>
@endsection
