@extends('layouts.blog')

@section('title', 'Manage Categories — Admin')
@section('hide_footer', true)

@section('content')
<div class="admin-layout">
    @include('admin.partials.sidebar')

    <div class="admin-content">
        <h1>Manage Categories</h1>

        {{-- Create Category --}}
        <div style="background:var(--white);padding:20px;border-radius:var(--radius-md);border:1px solid var(--lighter-gray);margin-bottom:24px;" class="animate-fade-in-up">
            <h3 style="font-size:14px;font-weight:600;margin-bottom:12px;">Add New Category</h3>
            <form method="POST" action="{{ route('admin.categories.store') }}" style="display:flex;gap:12px;align-items:end;">
                @csrf
                <div class="form-group" style="margin:0;flex:1;">
                    <input type="text" name="name" class="form-input" placeholder="Category name" required value="{{ old('name') }}">
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="btn btn-dark btn-sm">Add</button>
            </form>
        </div>

        {{-- Categories List --}}
        <div class="data-table animate-fade-in-up">
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
                            <form method="POST" action="{{ route('admin.categories.update', $category) }}" style="display:flex;gap:8px;align-items:center;" id="edit-cat-{{ $category->id }}">
                                @csrf @method('PATCH')
                                <input type="text" name="name" value="{{ $category->name }}" class="form-input" style="padding:6px 10px;font-size:14px;max-width:200px;">
                                <button type="submit" class="btn btn-ghost btn-sm" style="font-size:12px;">Save</button>
                            </form>
                        </td>
                        <td style="color:var(--light-gray);">{{ $category->slug }}</td>
                        <td>{{ $category->posts_count }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete category &quot;{{ $category->name }}&quot;? Posts won\'t be deleted.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger);">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:32px;color:var(--light-gray);">No categories yet. Create one above.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
