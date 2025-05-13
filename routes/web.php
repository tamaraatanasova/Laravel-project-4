<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiscussionController;

Route::get('/',  [HomeController::class, 'index'])->name('home');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('discussions', DiscussionController::class);
    Route::resource('comments', CommentController::class);
    
    Route::post('discussions/{discussion}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/discussions/{id}/approve', [DiscussionController::class, 'approve'])->name('discussions.approve');
    Route::post('/discussions/{id}/unapprove', [DiscussionController::class, 'unapprove'])->name('discussions.unapprove');
    Route::post('/discussions/approve-all', [DiscussionController::class, 'approveAll'])->name('discussions.approveAll');
    Route::get('discussions/{discussion}/comments/create', [CommentController::class, 'create'])->name('comments.create');

});

require __DIR__ . '/auth.php';
