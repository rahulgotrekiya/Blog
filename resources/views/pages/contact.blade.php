@extends('layouts.blog')

@section('title', 'Contact Us — Blog')
@section('meta_description', 'Get in touch with the Blog team. We would love to hear from you.')

@section('content')
<div class="container" style="max-width:640px;margin:60px auto;padding:0 24px;">
    <h1 style="font-size:2.2rem;font-weight:700;margin-bottom:12px;">Contact Us</h1>
    <p style="color:var(--medium-gray);font-size:1.05rem;margin-bottom:40px;">Have a question, suggestion, or just want to say hello? We'd love to hear from you.</p>

    <div style="border-top:1px solid var(--border);padding-top:32px;">
        <div style="background:var(--bg-secondary,#f9f9f9);border:1px solid var(--border);border-radius:12px;padding:32px;text-align:center;">
            <div style="font-size:2.5rem;margin-bottom:16px;">✉️</div>
            <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:8px;">Reach out via email</h2>
            <p style="color:var(--medium-gray);font-size:0.95rem;margin-bottom:20px;">
                This is a college project. For any inquiries, feel free to reach out directly.
            </p>
            <a href="mailto:admin@blog.com" style="display:inline-block;background:var(--text-primary,#111);color:#fff;padding:10px 24px;border-radius:6px;font-size:0.9rem;font-weight:600;text-decoration:none;">
                admin@blog.com
            </a>
        </div>

        <p style="margin-top:32px;font-size:0.9rem;color:var(--light-gray);text-align:center;">
            A full contact form with admin inbox is coming soon.
        </p>
    </div>
</div>
@endsection
