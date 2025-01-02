@extends('layout')

@section('title', 'Pricing')

@section('content')

<!-- Pricing Section -->
<div id="pricing" class="pricing-section">
    <div class="container">
        <h2>Pricing</h2>
        <p>Choose the plan that fits your needs. Whether you're looking to join our gym or take specialized classes, we have something for you!</p>

        <!-- Pricing Categories -->
        <div class="pricing-category">
            <h3>Gym Membership Pricing</h3>
            <p class="category-description">Join Harmony Gym and get access to state-of-the-art equipment and fitness facilities.</p>

            <div class="pricing-cards">
                @foreach ($memberships as $membership)
                <div class="pricing-card">
                    <h4>{{$membership->type}}</h4>
                    <p class="price">${{ number_format($membership->price, 0) }}/{{$membership->duration}} Months</p>
                    <ul>
                        @php
                            // Convert the benefits string to an array (assuming it's comma-separated)
                            $benefits = is_string($membership->benefits) ? explode(',', $membership->benefits) : $membership->benefits;
                        @endphp

                        @foreach ($benefits as $benefit)
                            <li>{{ trim($benefit) }}</li>
                        @endforeach
                    </ul>
                    <span>Payment is on floor</span>
                    {{-- <a href="#signup" class="cta-button">Join Now</a> --}}
                </div>
                @endforeach
            </div>
        </div>

        <!-- Classes Pricing -->
        <div class="pricing-category">
            <h3>Class Pricing</h3>
            <p class="category-description">Join our specialized fitness classes and enhance your workout experience. Yoga, Zumba, and more!</p>

            <div class="pricing-cards">
                @foreach ($classes as $class)
                <div class="pricing-card">
                    <h4>{{$class->class_name}} Class</h4>
                    <p class="price">${{$class->price}}/month</p>
                    <span style="font-size: 20px; display: inline-block;">Trainer: </span><p style="color: #1a1a1a; display: inline-block; margin-left: 5px;">{{$class->trainer->name}}</p>
                    <img style="border-radius: 50%" src="{{asset('storage/images/'.$class->trainer->image)}}" alt="{{$class->trainer->name}}"  class="service-image">
                    {{-- <a href="#signup" class="cta-button">Join Now</a> --}}
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection
