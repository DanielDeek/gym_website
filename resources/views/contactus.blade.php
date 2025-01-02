@extends('layout')

@section('title','Contact Us')

@section('content')
    <!-- Contact Us Page -->
<div id="contact" class="contact-section">
    <div class="container">
        <h2>Contact Us</h2>
        <p>We’d love to hear from you! Whether you have a question or want to join our community, reach out to us.</p>

        <!-- Contact Form -->
        <div class="contact-form">
            <h3>Get in Touch</h3>
            <form action="{{route('contactus.post')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your name">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Write your message here..."></textarea>
                </div>

                <button type="submit" class="cta-button">Send Message</button>
            </form>
        </div>

    </div>
</div>

@endsection
