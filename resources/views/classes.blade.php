@extends('layout')

@section('title', 'Gym Classes')

@section('content')

<!-- Hero Section for Gym Classes Page -->
<div id="classes-hero" class="hero-section">
    <div class="hero-content">
        <img src="{{ asset('images/background.png') }}" alt="Gym Classes Background" class="hero-image">
        <div class="hero">
            <h1>Join Our Gym Classes</h1>
            <p>We offer a variety of classes that cater to all fitness levels. Join today and take your fitness to the next level!</p>
        </div>
    </div>
</div>

<!-- Classes Overview Section -->
<div id="classes-overview" class="classes-overview">
    <div class="container">
        <h2>Our Classes</h2>
        <p>At Harmony Gym, we offer a diverse range of classes designed to help you reach your fitness goals. Whether you're a beginner or an experienced athlete, we have something for everyone.</p>


        <div class="class-cards">
            @foreach ($classes as $class)
                <div class="class-card">
                    <img src="{{ asset('storage/images/'.$class->image) }}" alt="{{$class->class_name}}" class="class-image">
                    <h3>{{$class->class_name}}</h3>
                    <p>{{$class->description}}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Class Schedule Section -->
<div id="class-schedule" class="schedule-section">
    <div class="container">
        <h2>Class Schedule</h2>
        <p>Check out our weekly class schedule and find the perfect class for you.</p>

        <div class="schedule-table">
            <table>
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Days</th>
                        <th>Time</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $class)
                    <tr>
                        <td>{{$class->class_name}}</td>
                        <td>{{$class->day_of_week}}</td>
                        <td>{{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($class->end_time)->format('h:i A') }}</td>
                        <td>${{$class->price}}/Month</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
