<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ProgramstudiesController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ContentsController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\MenurolesController;

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

// !!!! ROUTE FOR INERTIA REACT !!!!
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Program Study
Route::get('/program-study', function () {
    // $data = session()->get('Variable')->getContent();
    $data = session()->get('SessTableData');
    return Inertia::render('Prodi/ProgramStudies',['data'=>$data]);
})->middleware(['auth', 'verified'])->name('prodi.programstudies');
Route::get('/program-study/add', function () {
    $data_selection = session()->get('SessSelectionData');
    return Inertia::render('Prodi/FormProgramStudy',['data_selection'=>$data_selection]);
})->middleware(['auth', 'verified'])->name('prodi.formprogramstudy');
Route::get('/program-study/show', function () {
    $data = session()->get('SessTableData');
    return Inertia::render('Prodi/FormProgramStudy',['data'=>$data]);
})->middleware(['auth', 'verified'])->name('prodi.programstudy-show');

// DOSEN
Route::get('/lecturer', function () {
    $data = session()->get('SessTableData');
    return Inertia::render('Lecturer/Lecturers',['data'=>$data]);
})->middleware(['auth', 'verified'])->name('lecturer.lecturers');
Route::get('/lecturer/add', function () {
    $data = session()->get('SessSelectionData');
    return Inertia::render('Lecturer/FormLecturer',['data_selection'=>$data_selection]);
})->middleware(['auth', 'verified'])->name('lecturer.formlecturer');
Route::get('/lecturer/show', function () {
    $data = session()->get('SessTableData');
    $data_selection = session()->get('SessSelectionData');
    return Inertia::render('Lecturer/FormLecturer',['data'=>$data,'data_selection'=>$data_selection]);
})->middleware(['auth', 'verified'])->name('lecturer.lecturer-show');

// ROOM
Route::get('/room', function () {
    $data = session()->get('SessTableData');
    return Inertia::render('Room/Rooms',['data'=>$data]);
})->middleware(['auth', 'verified'])->name('room.rooms');
Route::get('/room/add', function () {
    $data = session()->get('SessSelectionData');
    return Inertia::render('Room/FormRoom');
})->middleware(['auth', 'verified'])->name('room.formroom');
Route::get('/room/show', function () {
    $data = session()->get('SessTableData');
    $data_selection = session()->get('SessSelectionData');
    return Inertia::render('Room/FormRoom',['data'=>$data,'data_selection'=>$data_selection]);
})->middleware(['auth', 'verified']);

// Subject
Route::get('/subject', function () {
    $data = session()->get('SessTableData');
    return Inertia::render('Subject/Subjects',['data'=>$data]);
})->middleware(['auth', 'verified'])->name('subject.subjects');
Route::get('/subject/add', function () {
    $data = session()->get('SessSelectionData');
    return Inertia::render('Subject/FormSubject');
})->middleware(['auth', 'verified'])->name('subject.formsubject');
Route::get('/subject/show', function () {
    $data = session()->get('SessTableData');
    $data_selection = session()->get('SessSelectionData');
    return Inertia::render('Subject/FormSubject',['data'=>$data,'data_selection'=>$data_selection]);
})->middleware(['auth', 'verified']);


// !!!! ROUTE FOR INERTIA REACT !!!!

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
 
      // User
      Route::get('/user-page', [UsersController::class, 'index'])->name('user.index');
      Route::get('/user-create', [UsersController::class, 'create'])->name('user.create');
      Route::post('/user-store', [UsersController::class, 'store']);
      Route::get('/user-show/{id}', [UsersController::class, 'show'])->name('user.show');
      Route::put('/user-update/{id}', [UsersController::class, 'update'])->name('user.update');
      Route::delete('/user-destroy/{id}', [UsersController::class, 'destroy'])->name('user.delete');
 
      // Content
      Route::get('/content-page', [ContentsController::class, 'index'])->name('content.index');
      Route::get('/content-create', [ContentsController::class, 'create'])->name('content.create');
      Route::post('/content-store', [ContentsController::class, 'store']);
      Route::get('/content-show/{id}', [ContentsController::class, 'show'])->name('content.show');
      Route::put('/content-update/{id}', [ContentsController::class, 'update'])->name('content.update');
      Route::delete('/content-destroy/{id}', [ContentsController::class, 'destroy'])->name('content.delete');
      
      // Content
      Route::get('/menu-page', [MenusController::class, 'index'])->name('menu.index');
      Route::get('/menu-create', [MenusController::class, 'create'])->name('menu.create');
      Route::post('/menu-store', [MenusController::class, 'store']);
      Route::get('/menu-show/{id}', [MenusController::class, 'show'])->name('menu.show');
      Route::put('/menu-update/{id}', [MenusController::class, 'update'])->name('menu.update');
      Route::delete('/menu-destroy/{id}', [MenusController::class, 'destroy'])->name('menu.delete');
 
      // TX Menu Role
      Route::get('/menurole-page', [MenurolesController::class, 'index'])->name('menurole.index');
      Route::get('/menurole-create', [MenurolesController::class, 'create'])->name('menurole.create');
      Route::post('/menurole-store', [MenurolesController::class, 'store']);
      Route::get('/menurole-show/{id}', [MenurolesController::class, 'show'])->name('menurole.show');
      Route::put('/menurole-update/{id}', [MenurolesController::class, 'update'])->name('menurole.update');
      Route::delete('/menurole-destroy/{id}', [MenurolesController::class, 'destroy'])->name('menurole.delete');
 

});

require __DIR__.'/auth.php';
