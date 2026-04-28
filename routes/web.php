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
//Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/show', [UserController::class, 'show'])->name('users.show');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/fetchData', [UserController::class, 'fetchData'])->name('users.fetchData');
Route::post('/users/userRole', [UserController::class, 'userRole'])->name('users.userRole');
Route::get('/users/{id}/delete', [UserController::class, 'userdelete'])->name('user.delete');
Route::get('/users/{id}/edit', [UserController::class, 'useredit'])->name('edit.delete');
Route::put('/users/{id}/update', [UserController::class, 'update'])->name('user.update');

//Archery
Route::get('/archers/create', [AcheryController::class, 'create'])->name('achers.create');
Route::post('/archers/store', [AcheryController::class, 'store'])->name('achers.store');
Route::get('/archers/index', [AcheryController::class, 'index'])->name('achers.index');
Route::get('/viewmore/{id}', [AcheryController::class, 'viewmore'])->name('viewmore');
Route::get('/archer/edit/{id}', [AcheryController::class, 'edit'])->name('archer.edit');
Route::get('/archer/certificate/{id}', [GradingController::class, 'certificate'])->name('archer.certificate');
Route::put('/archer/update/{id}', [AcheryController::class, 'update'])->name('archer.update');
Route::get('/historydetails/{id}', [AcheryController::class, 'historydetails'])->name('historydetails');

Route::get('/grading/scores', [GradingController::class, 'scores'])->name('grading.scores');
Route::post('/grading/store', [GradingController::class, 'store'])->name('grading.store');

//events
Route::put('/event/update/{id}', [GradingController::class, 'update'])->name('event.updateEvent');
Route::get('/events/createCategory', [GradingController::class, 'createCategory'])->name('events.createCategory');
Route::get('/events/indexeventCategory', [GradingController::class, 'indexeventCategory'])->name('events.indexeventCategory');
Route::get('/events/indexevent', [GradingController::class, 'indexevent'])->name('events.indexevent');
Route::post('/event/storeCategory', [GradingController::class, 'storeCategory'])->name('event.storeCategory');
Route::post('/event/eventStore', [GradingController::class, 'eventStore'])->name('event.eventStore');
Route::post('/event/archerDetails', [GradingController::class, 'archerDetails'])->name('event.archerDetails');
Route::post('/event/editScore', [GradingController::class, 'editScore'])->name('event.editScore');
Route::post('/grading/updateScore', [GradingController::class, 'updateScore'])->name('event.updateScore');
Route::get('/events/create', [GradingController::class, 'createEvent'])->name('events.create');
Route::get('/events/manage', [GradingController::class, 'manage'])->name('events.manage');
Route::get('/events/scoring', [GradingController::class, 'scoring'])->name('events.scoring');
Route::get('/events/showEvent/{id}', [GradingController::class, 'showEvent'])->name('events.showEvent');
Route::get('/grading/download/{id}', [AcheryController::class, 'downloadGrading'])->name('grading.download');
Route::get('/editeventCategory/{id}', [GradingController::class, 'editeventCategory'])->name('editeventCategory');
Route::get('/editevent/{id}', [GradingController::class, 'editevent'])->name('editevent');
Route::get('/deletearcher/{archer_id}/{event_id}', [GradingController::class, 'deletearcher'])->name('deletearcher');
Route::get('/gradearcher/{id}', [GradingController::class, 'gradearcher'])->name('gradearcher');

Route::get('/events/{id}/rawscores', [GradingController::class, 'rawscores'])->name('reports.rawscores');
Route::get('/events/{id}/scoresummary', [GradingController::class, 'scoresummary'])->name('reports.scoresummary');
Route::get('/events/{id}/supersummary', [GradingController::class, 'supersummary'])->name('reports.supersummary');

Route::get('/endevent/{id}', [GradingController::class, 'endevent'])->name('endevent');
Route::post('/event/storeCategory', [GradingController::class, 'storeCategory'])->name('event.storeCategory');
Route::get('/editeventCategory2/{id}', [GradingController::class, 'editEventCategory2'])->name('event.editCategory2');

Route::put('/updateeventCategory/{id}', [GradingController::class, 'updateEventCategory'])->name('event.updateCategory');

Route::post('/grading/details', [GradingController::class, 'gradingdetail'])->name('grading.details');
Route::post('/grading/confirmscores', [GradingController::class, 'finalgradingdetail'])->name('grading.confirmscores');


});

require __DIR__.'/auth.php';
