@extends('admin.layout')

@section('content')
    <div class="users">
        <h2>Contact Message Details</h2>

        <p><strong>Name:</strong> {{ $contact->name }}</p>
        <p><strong>Email:</strong> {{ $contact->email }}</p>
        <p><strong>Message:</strong></p>
        <p>{{ $contact->message }}</p>

        <a href="{{ route('admin.contacts.index') }}" class="button">Back to Messages</a>
    </div>
@endsection
