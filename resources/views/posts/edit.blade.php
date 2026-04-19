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
                        <span class="cover-label-text">{{ $post->featured_image ? 'Change Image' : 'Cover Image' }}</span>
                        <input type="file" name="featured_image" accept="image/*" style="display:none;">
                    </label>
                </div>
                <button type="button" class="ai-trigger" id="ai-trigger" onclick="toggleAiPanel()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px;"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                    AI Assist
                </button>
            </div>
            <div class="editor-toolbar-right">
                <label class="form-check" style="font-size:14px;gap:6px;">
                    <input type="checkbox" name="is_published" value="1" {{ $post->is_published ? 'checked' : '' }}>
                    Published
                </label>
                <button type="submit" class="btn btn-dark btn-sm">Update</button>
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

        <input type="text" name="title" class="editor-title" placeholder="Title" value="{{ old('title', $post->title) }}" required>

        {{-- Cover image preview (existing or newly selected) --}}
        <div id="cover-preview-wrap" style="{{ $post->featured_image ? '' : 'display:none;' }}position:relative;margin-bottom:20px;border-radius:var(--radius-md);overflow:hidden;max-height:320px;">
            <img id="cover-preview-img"
                 src="{{ $post->featured_image ? Storage::url($post->featured_image) : '' }}"
                 alt="Cover preview"
                 style="width:100%;max-height:320px;object-fit:cover;display:block;">
            <button type="button" onclick="removeCoverImage()" style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,0.55);border:none;color:#fff;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:18px;line-height:1;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);" title="Remove image">&times;</button>
        </div>
        {{-- Hidden field to signal image removal --}}
        <input type="hidden" name="remove_featured_image" id="remove-image-flag" value="0">

        <div class="form-group">
            <input type="text" name="excerpt" class="form-input" placeholder="Write a brief excerpt..." value="{{ old('excerpt', $post->excerpt) }}" style="border:none;font-size:18px;color:var(--medium-gray);padding-left:0;">
        </div>

        <textarea name="body" class="editor-body" placeholder="Tell your story..." required>{{ old('body', $post->body) }}</textarea>
    </form>
</div>

<script>
function initCoverPreview() {
    const input = document.querySelector('input[name="featured_image"]');
    const wrap  = document.getElementById('cover-preview-wrap');
    const img   = document.getElementById('cover-preview-img');
    const label = input.closest('label');

    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                wrap.style.display = 'block';
                label.querySelector('.cover-label-text').textContent = 'Change Image';
                document.getElementById('remove-image-flag').value = '0';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
}

function removeCoverImage() {
    const input = document.querySelector('input[name="featured_image"]');
    const wrap  = document.getElementById('cover-preview-wrap');
    const label = input.closest('label');
    input.value = '';
    wrap.style.display = 'none';
    label.querySelector('.cover-label-text').textContent = 'Cover Image';
    document.getElementById('remove-image-flag').value = '1';
}

document.addEventListener('DOMContentLoaded', initCoverPreview);
</script>
@endsection
