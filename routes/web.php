<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Poll system
    Route::get('/polls', [PollController::class, 'index']);
    Route::get('/polls/{id}', [PollController::class, 'show']);
    Route::get('/poll/{id}/results', [PollController::class, 'results']);
    Route::post('/vote', [VoteController::class, 'vote']);

    // Admin
    Route::get('/admin/poll/{id}/ips', [AdminController::class, 'ips']);
    Route::post('/admin/release-ip', [AdminController::class, 'releaseIp']);
});


require __DIR__.'/auth.php';
