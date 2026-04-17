<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AiAssistController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
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
    Route::post('/post/{post}/comment', [CommentController::class, 'store'])->name('comment.store')->middleware('throttle:10,1');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // Likes
    Route::post('/post/{post}/like', [LikeController::class, 'toggle'])->name('like.toggle')->middleware('throttle:30,1');

    // Profile settings (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // AI Writing Assistant
    Route::prefix('ai')->name('ai.')->middleware('throttle:15,1')->group(function () {
        Route::post('/generate-excerpt', [AiAssistController::class, 'generateExcerpt'])->name('excerpt');
        Route::post('/suggest-category', [AiAssistController::class, 'suggestCategory'])->name('category');
        Route::post('/improve-writing', [AiAssistController::class, 'improveWriting'])->name('improve');
        Route::post('/generate-outline', [AiAssistController::class, 'generateOutline'])->name('outline');
    });
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

    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::patch('/messages/{message}/read', [AdminMessageController::class, 'markAsRead'])->name('messages.markAsRead');
    Route::post('/messages/{message}/reply', [AdminMessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');
});

require __DIR__.'/auth.php';
