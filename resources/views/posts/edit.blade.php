@extends('layouts.blog')

@section('title', 'Edit: ' . $post->title . ' — Blog')

@section('content')
<div class="container-narrow page-content">
    <form method="POST" action="{{ route('post.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="editor-toolbar">
            <div class="editor-toolbar-left">
                <div class="form-group" style="margin:0;">
                    <select name="category_id" class="form-select" style="width:auto;padding:8px 12px;font-size:13px;">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="btn btn-outline btn-sm" style="cursor:pointer;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        {{ $post->featured_image ? 'Change Image' : 'Cover Image' }}
                        <input type="file" name="featured_image" accept="image/*" style="display:none;">
                    </label>
                </div>
            </div>
            <div class="editor-toolbar-right">
                <label class="form-check" style="font-size:14px;gap:6px;">
                    <input type="checkbox" name="is_published" value="1" {{ $post->is_published ? 'checked' : '' }}>
                    Published
                </label>
                <button type="submit" class="btn btn-dark btn-sm">Update</button>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </div>
        @endif

        <input type="text" name="title" class="editor-title" placeholder="Title" value="{{ old('title', $post->title) }}" required>

        <div class="form-group">
            <input type="text" name="excerpt" class="form-input" placeholder="Write a brief excerpt..." value="{{ old('excerpt', $post->excerpt) }}" style="border:none;font-size:18px;color:var(--medium-gray);padding-left:0;">
        </div>

        <textarea name="body" class="editor-body" placeholder="Tell your story..." required>{{ old('body', $post->body) }}</textarea>
    </form>
</div>
@endsection
