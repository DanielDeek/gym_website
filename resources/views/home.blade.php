@extends('layout')

@section('title','Home')

@section('content')
<div id="hero" class="hero-section">
    <div class="hero-content">
        @if ($home)
        <img src="{{ $home->background_image ? asset('storage/' . $home->background_image) : asset('images/background.png') }}" alt="Background Image" class="hero-image">
        <div class="heros">
            <h1>{{$home->title}}</h1>
            <p>{{$home->description}}</p>
            <p><b>{{$home->operating_hours}}</b></p>
            <div class="join-us">
                <a href="{{route('pricing')}}" class="cta-button">Join Now</a>
            </div>
        </div>
        @endif

    </div>
</div>
<div id="about" class="about-section">
    <div class="about-wrapper">
        @if($about)
        <!-- Left Content -->
        <div class="about-text">
            <h2>About Us</h2>
            <p>
                {{$about->description}}
            </p>
            <h3>Our Philosophy</h3>
            <p>
                {{$about->philosophy_description}}
            </p>
            <a href="#services" class="learn-more-button">Learn More About Us</a>
        </div>

        <!-- Right Image -->
        <div class="about-image">
            <img src="{{ asset('storage/' . $about->image)}}" alt="About Image">
        </div>
        @endif
    </div>
</div>

<div id="services" class="services-section">
    <div class="services-container">
        <h2>Our Services</h2>
        <p class="services-intro">At Harmony Gym, we offer a variety of services to help you achieve your fitness goals. Explore what we have to offer!</p>

        <div class="service-cards">
            @foreach ($services as $service)
            <div class="service-card">
                    <img src="{{asset('storage/images/'. $service->image)}}" alt="{{$service->name}}" class="service-image">
                    <h3 >{{$service->name}}</h3>
                    <p>{{$service->description}}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>


@endsection
