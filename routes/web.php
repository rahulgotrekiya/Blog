<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/@{username}', [UserProfileController::class, 'show'])->name('profile.public');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard — my posts
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');

    // Post CRUD - must come BEFORE /post/{post} to avoid route conflicts
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    // Comments
    Route::post('/post/{post}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // Likes
    Route::post('/post/{post}/like', [LikeController::class, 'toggle'])->name('like.toggle');

    // Profile settings (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public post view - must come AFTER authenticated routes to avoid conflicts
Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::patch('/posts/{post}/toggle-featured', [AdminPostController::class, 'toggleFeatured'])->name('posts.toggleFeatured');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__.'/auth.php';
