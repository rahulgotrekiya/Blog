@extends('layouts.blog')

@section('title', 'Contact Us — Blog')
@section('meta_description', 'Get in touch with the Blog team. We would love to hear from you.')

@section('content')
<div class="container-narrow" style="padding: 60px 24px;">
    <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 8px;">Contact Us</h1>
    <p style="color: var(--medium-gray); font-size: 16px; margin-bottom: 32px;">Have a question, suggestion, or just want to say hello? We'd love to hear from you.</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" style="padding-top: 24px;">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" placeholder="Your name" required>
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="your@email.com" required>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" id="subject" name="subject" class="form-input" value="{{ old('subject') }}" placeholder="What is this about?" required>
            @error('subject')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="message" class="form-label">Message</label>
            <textarea id="message" name="message" class="form-textarea" placeholder="Your message (minimum 10 characters)" required>{{ old('message') }}</textarea>
            @error('message')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-dark btn-lg" style="width: 100%;">Send Message</button>
    </form>

    <p style="margin-top: 32px; font-size: 14px; color: var(--light-gray); text-align: center;">
        We'll receive your message and get back to you as soon as possible.
    </p>
</div>
@endsection
