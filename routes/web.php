<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\PostController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::get('about', fn() => Inertia::render('About', [
    'title' => 'О нас',
    'description' => 'Это страница о нашем форуме'
]))->middleware('log.visits')->name('about');

Route::post('feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::get('posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/forum', [CategoryController::class, 'index'])->name('forum.index');
Route::get('/forum/{category:slug}', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/forum/{category:slug}/{thread:slug}', [ThreadController::class, 'show'])->name('threads.show');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('posts', PostController::class)->except(['index']);
    Route::inertia('dashboard', 'Dashboard')->middleware('log.visits')->name('dashboard');
    Route::get('/forum/{category:slug}/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::post('/forum/{category:slug}', [ThreadController::class, 'store'])->name('threads.store');

});

require __DIR__.'/settings.php';
