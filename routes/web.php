<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AcheryController;
use App\Http\Controllers\GradingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


Route::get('/users/parameters', [UserController::class, 'parameters'])->name('users.parameters');
Route::get('/users/index', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/show', [UserController::class, 'show'])->name('users.show');
Route::get('/users/fetchData', [UserController::class, 'fetchData'])->name('users.fetchData');
Route::post('/users/userRole', [UserController::class, 'userRole'])->name('users.userRole');
Route::get('/users/{id}/delete', [UserController::class, 'userdelete'])->name('user.delete');
Route::get('/users/{id}/edit', [UserController::class, 'useredit'])->name('edit.delete');
Route::put('/users/{id}/update', [UserController::class, 'update'])->name('user.update');

//Archery
Route::get('/archers/create', [AcheryController::class, 'create'])->name('achers.create');
Route::post('/archers/store', [AcheryController::class, 'store'])->name('achers.store');


Route::get('/grading/scores', [GradingController::class, 'scores'])->name('grading.scores');
Route::post('/grading/store', [GradingController::class, 'store'])->name('grading.store');

Route::get('/events/createCategory', [GradingController::class, 'createCategory'])->name('events.createCategory');
Route::post('/event/storeCategory', [GradingController::class, 'storeCategory'])->name('event.storeCategory');
Route::get('/events/create', [GradingController::class, 'createEvent'])->name('events.create');
Route::get('/events/manage', [GradingController::class, 'manage'])->name('events.manage');
Route::get('/events/scoring', [GradingController::class, 'scoring'])->name('events.scoring');
Route::get('/events/showEvent/{id}', [GradingController::class, 'showEvent'])->name('events.showEvent');
Route::get('/gradearcher/{id}', [GradingController::class, 'gradearcher'])->name('gradearcher');
Route::post('/event/storeCategory', [GradingController::class, 'storeCategory'])->name('event.storeCategory');

Route::post('/grading/details', [GradingController::class, 'gradingdetail'])->name('grading.details');
Route::post('/grading/confirmscores', [GradingController::class, 'finalgradingdetail'])->name('grading.confirmscores');


});

require __DIR__.'/auth.php';
