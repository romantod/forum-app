<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\FeedbackController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('about', fn() => Inertia::render('About', [
        'title' => 'О нас',
        'description' => 'Это страница о нашем форуме'
    ]))->name('about');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});



require __DIR__.'/settings.php';
