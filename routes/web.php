<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeTrackingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/time-tracking', [TimeTrackingController::class, 'showTimeTracking'])->name('time-tracking');
    Route::get('/time-work', [TimeTrackingController::class, 'showUserTimeEntries'])->name('show-user-hours');
    Route::post('/clock-in', [TimeTrackingController::class, 'clockIn']);
    Route::post('/clock-out', [TimeTrackingController::class, 'clockOut']);
    Route::post('/request-leave', [TimeTrackingController::class, 'requestLeave']);
    Route::get('api/user/{userId}/summary', [TimeTrackingController::class, 'getSummary']);
    Route::get('api/user/{userId}/entries', [TimeTrackingController::class, 'getEntries']);
    Route::delete('api/entries/{entryId}', [TimeTrackingController::class, 'deleteEntry']);
    Route::post('api/user/pause', [TimeTrackingController::class, 'pause']);
    Route::post('api/user/resume', [TimeTrackingController::class, 'resume']);
});

Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('/'); // oder zu einer anderen Seite umleiten
})->name('logout');

Route::resource('dashboard', \App\Http\Controllers\DashboardController::class)->middleware(['auth', 'verified']);

Route::get('json', [\App\Http\Controllers\JSONController::class, 'json'])->name('json');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
