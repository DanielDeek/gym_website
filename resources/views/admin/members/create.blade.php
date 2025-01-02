@extends('admin.layout')

@section('content')
    <div class="form-container">
        <h1>Add New Member</h1>

        <form action="{{ route('admin.members.create') }}" method="POST">
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
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="membership_id">Membership Plan</label>
                <select name="membership_id" id="membership_id" onchange="updateEndDate()">
                    <option value="">Select Plan</option>
                    @foreach ($memberships as $membership)
                        <option value="{{$membership->id}}" data-type="{{ $membership->type }}" data-duration="{{ $membership->duration }}">
                            {{ $membership->type }} ({{ $membership->duration }} months)
                        </option>
                    @endforeach
                </select>
                @error('membership_id')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" onchange="updateEndDate()" required>
                @error('start_date')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" >
                @error('end_date')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="button">Create Member</button>
        </form>
    </div>

    @push('scripts')
        <script src="{{asset('js/scripts.js')}}"></script>
    @endpush
@endsection
