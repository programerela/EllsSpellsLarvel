<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
 
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])->name('dashboard');
Route::post('admin/approve', [AdminController::class, 'approve'])->name('admin.approve');
Route::post('admin/reject', [AdminController::class, 'reject'])->name('admin.reject');
Route::get('admin/theme-requests', [AdminController::class, 'themeRequests'])->name('admin.theme-requests');
Route::post('admin/approve-theme', [AdminController::class, 'approveTheme'])->name('admin.approve-theme');
Route::post('admin/reject-theme', [AdminController::class, 'rejectTheme'])->name('admin.reject-theme');

Route::get('theme', fn () => to_route('theme.index'));

Route::resource('theme', ThemeController::class)
    ->only(['index', 'show', 'follows', 'edit', 'update', 'create', 'store', 'destroy']);

// Route::get('theme/followed', [ThemeController::class, 'follows'])->name('theme.followed');
Route::post('theme/{theme}/follow', [ThemeController::class, 'follow'])->name('theme.follow');
Route::delete('theme/{theme}/unfollow', [ThemeController::class, 'unfollow'])->name('theme.unfollow');

Route::get('discussions/{discussion}', [DiscussionController::class, 'show'])->name('discussion.show');
Route::post('theme/{theme}/discussions', [DiscussionController::class, 'store'])->name('theme.discussions.store');
Route::get('user/themes', [AuthenticatedSessionController::class, 'myThemes'])->name('user.themes');
Route::get('user/themes/followed', [AuthenticatedSessionController::class, 'followed'])->name('user.themes.followed');
Route::get('user/discussions', [AuthenticatedSessionController::class, 'myDiscussions'])->name('user.discussions');
Route::resource('discussions', DiscussionController::class)
    ->only(['edit', 'update', 'destroy']);


    
    
Route::resource('discussion.comments', CommentController::class)
->only(['store']);
Route::resource('comment.replies', ReplyController::class)
->only(['store', 'edit', 'update']);
Route::post('comments/{comment}/vote', [CommentController::class, 'vote'])->name('comments.vote');

Route::post('themes/{theme}/user/{user}/block', [ThemeController::class, 'blockUser'])->name('themes.user.blockUser');
Route::delete('themes/{theme}/user/{user}/unblock', [ThemeController::class, 'unblockUser'])->name('themes.user.unblockUser');


Route::resource('posts', PostController::class)
    ->only(['show']);

require __DIR__.'/auth.php';