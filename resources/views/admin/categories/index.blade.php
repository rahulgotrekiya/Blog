@extends('layouts.admin')

@section('title', 'Manage Categories')
@section('breadcrumb', 'Categories')

@section('content')
<div class="adm-page-header">
    <h1 class="adm-page-title">Manage Categories</h1>
</div>

{{-- Add New Category --}}
<div class="adm-panel animate-fade-in-up" style="margin-bottom: 20px;">
    <div class="adm-panel-header">
        <h2>Add New Category</h2>
    </div>
    <div class="adm-panel-body">
        <form method="POST" action="{{ route('admin.categories.store') }}" style="display:flex;gap:12px;align-items:flex-start;">
            @csrf
            <div style="flex:1;">
                <input type="text" name="name" class="adm-form-input" style="width:100%;" placeholder="Category name" required value="{{ old('name') }}">
                @error('name') <p class="adm-form-error" style="margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="adm-btn adm-btn-dark">Add Category</button>
        </form>
    </div>
</div>

{{-- Categories Table --}}
<div class="adm-table-card animate-fade-in-up">
    <div class="adm-table-card-header">
        <h3>All Categories</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Posts</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td>
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}" style="display:flex;gap:8px;align-items:center;">
                        @csrf @method('PATCH')
                        <input type="text" name="name" value="{{ $category->name }}" class="adm-form-input" style="padding:6px 10px;font-size:13px;max-width:200px;">
                        <button type="submit" class="adm-btn adm-btn-outline adm-btn-sm">Save</button>
                    </form>
                </td>
                <td style="color:#888; font-size:13px;">{{ $category->slug }}</td>
                <td style="color:#555;">{{ $category->posts_count }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete category &quot;{{ $category->name }}&quot;? Posts won\'t be deleted.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="adm-btn adm-btn-ghost adm-btn-sm" style="color:#c94a4a;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; padding:32px; color:#aaa;">No categories yet. Create one above.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
