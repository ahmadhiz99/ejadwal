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
use App\Http\Controllers\TxMenuController;
use App\Http\Controllers\Sys_ContentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;

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


    Route::get('/', [MainController::class, 'index']);
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);

Route::get('/dashboard', [DashboardController::class, 'table'])->name('dashboard');

// !!!! ROUTE FOR INERTIA REACT !!!!
// Route::get('/dashboard', function () {
    // return Inertia::render('Dashboard');

// })->middleware(['auth', 'verified'])->name('dashboard');

// BUILDER
Route::get('/builder/table', function () {
    $data = session()->get('SessTableData');
    $dataResponse = session()->get('dataResponse');
    return Inertia::render('Builder/TableBuilder',['data'=>$data,'dataResponse'=>$dataResponse]);
})->middleware(['auth', 'verified'])->name('builder.table-builder');

Route::get('/builder/table/destory', function () {
    $data = session()->get('SessTableData');
    return Inertia::render('Builder/TableBuilder',['data'=>$data]);
})->middleware(['auth', 'verified'])->name('builder.table-builder');

Route::get('/builder/table/add', function () {
    $data = session()->get('SessFormData');
    // dd($data);
    return Inertia::render('Builder/FormBuilder',['data'=>$data]);
})->middleware(['auth', 'verified'])->name('builder.form-builder');

Route::get('/builder/table/edit', function () {
    $data = session()->get('SessFormData');
    // dd($data);
    return Inertia::render('Builder/FormBuilder',['data'=>$data]);
})->middleware(['auth', 'verified'])->name('builder.form-builder');

Route::get('/builder/table/show', function () {
    $data = session()->get('SessTableData');
    $data_selection = session()->get('SessSelectionData');
    return Inertia::render('SysMenu/FormMenu',['data'=>$data,'data_selection'=>$data_selection]);
})->middleware(['auth', 'verified']);

// END BUILDER


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

// End
Route::get('/content-page', [Sys_ContentController::class, 'index'])->name('content.index');

Route::group(['middleware' => 'checkRole:super,admin,client'], function() {


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

     // ROLE
     Route::get('/role-page', [RolesController::class, 'table'])->name('role.table');
     Route::get('/role-create', [RolesController::class, 'create'])->name('role.create');
     Route::post('/role-store', [RolesController::class, 'store']);
     Route::get('/role-show/{id}', [RolesController::class, 'show'])->name('role.show');
     Route::get('/role-edit/{id}', [RolesController::class, 'edit'])->name('role.edit');
     Route::put('/role-update/{id}', [RolesController::class, 'update'])->name('role.update');
     Route::delete('/role-destroy/{id}', [RolesController::class, 'destroy'])->name('role.delete');

     // Room
     Route::get('/room-page', [RoomsController::class, 'table'])->name('room.table');
     Route::get('/room-create', [RoomsController::class, 'create'])->name('room.create');
     Route::post('/room-store', [RoomsController::class, 'store']);
     Route::get('/room-show/{id}', [RoomsController::class, 'show'])->name('room.show');
     Route::get('/room-edit/{id}', [RoomsController::class, 'edit'])->name('room.edit');
     Route::put('/room-update/{id}', [RoomsController::class, 'update'])->name('room.update');
     Route::delete('/room-destroy/{id}', [RoomsController::class, 'destroy'])->name('room.delete');
    
     // Classes
     Route::get('/class-page', [ClassesController::class, 'table'])->name('class.table');
     Route::get('/class-create', [ClassesController::class, 'create'])->name('class.create');
     Route::post('/class-store', [ClassesController::class, 'store']);
     Route::get('/class-show/{id}', [ClassesController::class, 'show'])->name('class.show');
     Route::get('/class-edit/{id}', [ClassesController::class, 'edit'])->name('class.edit');
     Route::put('/class-update/{id}', [ClassesController::class, 'update'])->name('class.update');
     Route::delete('/class-destroy/{id}', [ClassesController::class, 'destroy'])->name('class.delete');

      // Program Studi
    //   Route::get('/programstudies-index', [ProgramstudiesController::class, 'index'])->name('programstudies.index');
      Route::get('/programstudies-page', [ProgramstudiesController::class, 'table'])->name('programstudies.table');
      Route::get('/programstudies-create', [ProgramstudiesController::class, 'create'])->name('programstudies.create');
      Route::post('/programstudies-store', [ProgramstudiesController::class, 'store']);
      Route::get('/programstudies-show/{id}', [ProgramstudiesController::class, 'show'])->name('programstudies.show');
      Route::get('/programstudies-edit/{id}', [ProgramstudiesController::class, 'edit'])->name('programstudies.edit');
      Route::put('/programstudies-update/{id}', [ProgramstudiesController::class, 'update'])->name('programstudies.update');
      Route::delete('/programstudies-destroy/{id}', [ProgramstudiesController::class, 'destroy'])->name('programstudies.delete');

      // Schedule
      Route::get('/schedule-page', [SchedulesController::class, 'table'])->name('schedule.table');
      Route::get('/schedule-create', [SchedulesController::class, 'create'])->name('schedule.create');
      Route::post('/schedule-store', [SchedulesController::class, 'store']);
      Route::get('/schedule-show/{id}', [SchedulesController::class, 'show'])->name('schedule.show');
      Route::get('/schedule-edit/{id}', [SchedulesController::class, 'edit'])->name('schedule.edit');
      Route::put('/schedule-update/{id}', [SchedulesController::class, 'update'])->name('schedule.update');
      Route::delete('/schedule-destroy/{id}', [SchedulesController::class, 'destroy'])->name('schedule.delete');
 
      // Subject
      Route::get('/subject-page', [SubjectsController::class, 'table'])->name('subject.table');
      Route::get('/subject-create', [SubjectsController::class, 'create'])->name('subject.create');
      Route::post('/subject-store', [SubjectsController::class, 'store']);
      Route::get('/subject-show/{id}', [SubjectsController::class, 'show'])->name('subject.show');
      Route::get('/subject-edit/{id}', [SubjectsController::class, 'edit'])->name('subject.edit');
      Route::put('/subject-update/{id}', [SubjectsController::class, 'update'])->name('subject.update');
      Route::delete('/subject-destroy/{id}', [SubjectsController::class, 'destroy'])->name('subject.delete');
 
      // User
      Route::get('/user-page', [UsersController::class, 'table'])->name('user.table');
      Route::get('/user-create', [UsersController::class, 'create'])->name('user.create');
      Route::post('/user-store', [UsersController::class, 'store'])->name('user.store');
      Route::get('/user-show/{id}', [UsersController::class, 'show'])->name('user.show');
      Route::get('/user-edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
      Route::put('/user-update/{id}', [UsersController::class, 'update'])->name('user.update');
      Route::delete('/user-destroy/{id}', [UsersController::class, 'destroy'])->name('user.delete');
 
      // Lecturer
      Route::get('/lecturer-page', [LecturerController::class, 'table'])->name('lecturer.table');
      Route::get('/lecturer-create', [LecturerController::class, 'create'])->name('lecturer.create');
      Route::post('/lecturer-store', [LecturerController::class, 'store']);
      Route::get('/lecturer-show/{id}', [LecturerController::class, 'show'])->name('lecturer.show');
      Route::get('/lecturer-edit/{id}', [LecturerController::class, 'edit'])->name('lecturer.edit');
      Route::put('/lecturer-update/{id}', [LecturerController::class, 'update'])->name('lecturer.update');
      Route::delete('/lecturer-destroy/{id}', [LecturerController::class, 'destroy'])->name('lecturer.delete');
 
      // Content
      Route::get('/content-page', [Sys_ContentController::class, 'table'])->name('content.table');
      Route::get('/content-create', [Sys_ContentController::class, 'create'])->name('content.create');
      Route::post('/content-store', [Sys_ContentController::class, 'store']);
      Route::get('/content-show/{id}', [Sys_ContentController::class, 'show'])->name('content.show');
      Route::put('/content-update/{id}', [Sys_ContentController::class, 'update'])->name('content.update');
      Route::delete('/content-destroy/{id}', [Sys_ContentController::class, 'destroy'])->name('content.delete');
      
      // Menu
      Route::get('/menu-page', [MenusController::class, 'index'])->name('menu.index');
      Route::get('/menu-table', [MenusController::class, 'table'])->name('menu.table');
      Route::get('/menu-create', [MenusController::class, 'create'])->name('menu.create');
      Route::post('/menu-store', [MenusController::class, 'store'])->name('menu.store');
      Route::get('/menu-show/{id}', [MenusController::class, 'show'])->name('menu.show');
      Route::get('/menu-edit/{id}', [MenusController::class, 'edit'])->name('menu.edit');
      Route::put('/menu-update/{id}', [MenusController::class, 'update'])->name('menu.update');
      Route::delete('/menu-destroy/{id}', [MenusController::class, 'destroy'])->name('menu.delete');
 
      // TX Menu Role
      Route::get('/txmenu-page', [TxMenuController::class, 'table'])->name('txmenu.table');
      Route::get('/txmenu-create', [TxMenuController::class, 'create'])->name('txmenu.create');
      Route::post('/txmenu-store', [TxMenuController::class, 'store']);
      Route::get('/txmenu-show/{id}', [TxMenuController::class, 'show'])->name('txmenu.show');
      Route::get('/txmenu-edit/{id}', [TxMenuController::class, 'edit'])->name('txmenu.edit');
      Route::put('/txmenu-update/{id}', [TxMenuController::class, 'update'])->name('txmenu.update');
      Route::delete('/txmenu-destroy/{id}', [TxMenuController::class, 'destroy'])->name('txmenu.delete');
      
      // Content
      Route::get('/content-page', [Sys_ContentController::class, 'index'])->name('content.index');
      Route::get('/content-table', [Sys_ContentController::class, 'table'])->name('content.table');
      Route::get('/content-create', [Sys_ContentController::class, 'create'])->name('content.create');
      Route::post('/content-store', [Sys_ContentController::class, 'store']);
      Route::get('/content-show/{id}', [Sys_ContentController::class, 'show'])->name('content.show');
      Route::get('/content-edit/{id}', [Sys_ContentController::class, 'edit'])->name('content.edit');
      Route::put('/content-update/{id}', [Sys_ContentController::class, 'update'])->name('content.update');
      Route::delete('/content-destroy/{id}', [Sys_ContentController::class, 'destroy'])->name('content.delete');
 

});

Route::group(['middleware' => 'checkRole:client'], function() {
    Route::inertia('/clientDashboard', 'ClientDashboard')->name('clientDashboard');
});


require __DIR__.'/auth.php';
