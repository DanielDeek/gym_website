@extends('admin.layout')

@section('content')
<div class="form-container">
    <h1>Add New Footer</h1>

    <form action="{{ route('admin.footer.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="description">Description</label><br>
            <textarea name="description" id="description"></textarea>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone">
        </div>
        <button type="submit" class="button">Add Footer</button>
    </form>
</div>
@endsection
