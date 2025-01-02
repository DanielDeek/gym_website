@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Add New Class</h1>

        <form action="{{ route('admin.classes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="class_name">Class Name</label>
                <input type="text" name="class_name" id="class_name" value="{{ old('class_name') }}" required>
                @error('class_name')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label><br>
                <textarea name="description" id="description">{{old('description')}}</textarea>
                @error('description')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="trainer_id">Trainer</label>
                <select name="trainer_id" id="trainer_id">
                    <option value="">Select Trainer</option>
                    @foreach ($trainers as $trainer)
                        <option value="{{ $trainer->id }}"
                            {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                            {{ $trainer->name }}
                        </option>
                    @endforeach
                </select>
                @error('trainer_id')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" class="form-control" id="start_time" value="{{ old('start_time') }}" required>
                @error('start_time')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" name="end_time" class="form-control" id="end_time" value="{{ old('end_time') }}" required>
                @error('end_time')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="day_of_week">Days of Week</label>
                <input type="text" name="day_of_week" id="day_of_week" value="{{ old('day_of_week') }}" required>
                @error('day_of_week')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" required>
                @error('price')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image">
                @error('image')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="button">Create Class</button>
        </form>
    </div>
@endsection
