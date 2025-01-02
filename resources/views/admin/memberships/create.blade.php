@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Add New Membership</h1>

        <form action="{{ route('admin.memberships.create') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" value="{{ old('type') }}" required>
                @error('type')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="price" name="price" id="price" value="{{ old('price') }}" required>
                @error('price')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="number" name="duration" id="duration" value="{{ old('duration') }}" required>
                @error('duration')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="benefits">Benifits</label><br>
                <textarea name="benefits" id="benefits" cols="30" rows="10">{{old('benefits')}}</textarea>
                @error('benefits')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="button">Create Membership</button>
        </form>
    </div>
@endsection
