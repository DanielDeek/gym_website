@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Add New Trainer</h1>

        <form action="{{ route('admin.trainers.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" >
                @error('phone')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="specialization">Specialization</label>
                <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" >
                @error('specialization')
                    <span>{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="bio">Bio</label><br>
                <textarea name="bio" id="bio">{{old('bio')}}</textarea>
                @error('bio')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*">
                @error('image')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="button">Create Trainer</button>
        </form>
    </div>

    @push('scripts')
        <script src="{{asset('js/scripts.js')}}"></script>
    @endpush
@endsection
