<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ProgramstudiesController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\SubjectsController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

     // ROLE
     Route::get('/role-page', [RolesController::class, 'index'])->name('roles.index');
     Route::get('/role-create', [RolesController::class, 'create'])->name('roles.create');
     Route::post('/role-store', [RolesController::class, 'store']);
     Route::get('/role-show/{id}', [RolesController::class, 'show'])->name('roles.show');
     Route::put('/role-update/{id}', [RolesController::class, 'update'])->name('roles.update');
     Route::delete('/role-destroy/{id}', [RolesController::class, 'destroy'])->name('roles.delete');

     // Room
     Route::get('/room-page', [RoomsController::class, 'index'])->name('rooms.index');
     Route::get('/room-create', [RoomsController::class, 'create'])->name('rooms.create');
     Route::post('/room-store', [RoomsController::class, 'store']);
     Route::get('/room-show/{id}', [RoomsController::class, 'show'])->name('rooms.show');
     Route::put('/room-update/{id}', [RoomsController::class, 'update'])->name('rooms.update');
     Route::delete('/room-destroy/{id}', [RoomsController::class, 'destroy'])->name('rooms.delete');
    
     // Classes
     Route::get('/class-page', [ClassesController::class, 'index'])->name('class.index');
     Route::get('/class-create', [ClassesController::class, 'create'])->name('class.create');
     Route::post('/class-store', [ClassesController::class, 'store']);
     Route::get('/class-show/{id}', [ClassesController::class, 'show'])->name('class.show');
     Route::put('/class-update/{id}', [ClassesController::class, 'update'])->name('class.update');
     Route::delete('/class-destroy/{id}', [ClassesController::class, 'destroy'])->name('class.delete');

      // Program Studi
      Route::get('/programstudies-page', [ProgramstudiesController::class, 'index'])->name('programstudies.index');
      Route::get('/programstudies-create', [ProgramstudiesController::class, 'create'])->name('programstudies.create');
      Route::post('/programstudies-store', [ProgramstudiesController::class, 'store']);
      Route::get('/programstudies-show/{id}', [ProgramstudiesController::class, 'show'])->name('programstudies.show');
      Route::put('/programstudies-update/{id}', [ProgramstudiesController::class, 'update'])->name('programstudies.update');
      Route::delete('/programstudies-destroy/{id}', [ProgramstudiesController::class, 'destroy'])->name('programstudies.delete');
 
      // Schedule
      Route::get('/schedule-page', [SchedulesController::class, 'index'])->name('schedule.index');
      Route::get('/schedule-create', [SchedulesController::class, 'create'])->name('schedule.create');
      Route::post('/schedule-store', [SchedulesController::class, 'store']);
      Route::get('/schedule-show/{id}', [SchedulesController::class, 'show'])->name('schedule.show');
      Route::put('/schedule-update/{id}', [SchedulesController::class, 'update'])->name('schedule.update');
      Route::delete('/schedule-destroy/{id}', [SchedulesController::class, 'destroy'])->name('schedule.delete');
 
      // Subject
      Route::get('/subject-page', [SubjectsController::class, 'index'])->name('subject.index');
      Route::get('/subject-create', [SubjectsController::class, 'create'])->name('subject.create');
      Route::post('/subject-store', [SubjectsController::class, 'store']);
      Route::get('/subject-show/{id}', [SubjectsController::class, 'show'])->name('subject.show');
      Route::put('/subject-update/{id}', [SubjectsController::class, 'update'])->name('subject.update');
      Route::delete('/subject-destroy/{id}', [SubjectsController::class, 'destroy'])->name('subject.delete');
 

});

require __DIR__.'/auth.php';
