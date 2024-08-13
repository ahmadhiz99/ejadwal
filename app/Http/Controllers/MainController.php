<?php
namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Helpers\ControllerHelper;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;


class MainController extends Controller
{
    public function index(){
        
        $day = $dayOfWeek = \Carbon\Carbon::now()->dayOfWeek;

        // $schedule = Schedule::all();
        $schedules = DB::table('schedules')
                        ->leftJoin('classes', 'schedules.class_id', '=', 'classes.id')
                        ->leftJoin('rooms', 'schedules.room_id', '=', 'rooms.id')
                        ->leftJoin('subjects', 'schedules.subject_id', '=', 'subjects.id')
                        ->leftJoin('users', 'schedules.user_id', '=', 'users.id')
                        ->leftJoin('hari', 'schedules.day', '=', 'hari.id')
                    ->select('schedules.*', 'users.name', 'classes.class_name', 'rooms.room_name', 'subjects.subject_name', 'hari.day_english' )
                    ->where('hari.id', $day)
                    ->get();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'data' => $schedules
        ]);
    }
}