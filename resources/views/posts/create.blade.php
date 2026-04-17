@extends('layouts.blog')

@section('title', 'Write a Story — Blog')

@section('content')
<div class="container-narrow page-content">
    <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="editor-toolbar">
            <div class="editor-toolbar-left">
                <div class="form-group" style="margin:0;">
                    <select name="category_id" class="form-select" style="width:auto;padding:8px 12px;font-size:13px;">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="btn btn-outline btn-sm" style="cursor:pointer;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        Cover Image
                        <input type="file" name="featured_image" accept="image/*" style="display:none;" onchange="this.parentElement.querySelector('span')?.remove(); const s=document.createElement('span'); s.textContent='✓ Selected'; this.parentElement.appendChild(s);">
                    </label>
                </div>
                <button type="button" class="ai-trigger" id="ai-trigger" onclick="toggleAiPanel()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px;"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                    AI Assist
                </button>
            </div>
            <div class="editor-toolbar-right">
                <label class="form-check" style="font-size:14px;gap:6px;">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                    Publish
                </label>
                <button type="submit" class="btn btn-dark btn-sm">Save</button>
            </div>
        </div>

        {{-- AI Panel --}}
        @include('posts.partials.ai-panel')

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </div>
        @endif

        <input type="text" name="title" class="editor-title" placeholder="Title" value="{{ old('title') }}" required>

        <div class="form-group">
            <input type="text" name="excerpt" class="form-input" placeholder="Write a brief excerpt..." value="{{ old('excerpt') }}" style="border:none;font-size:18px;color:var(--medium-gray);padding-left:0;">
        </div>

        <textarea name="body" class="editor-body" placeholder="Tell your story..." required>{{ old('body') }}</textarea>
    </form>
</div>
@endsection
