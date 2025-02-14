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
        
        $day = $dayOfWeek = \Carbon\Carbon::now('Asia/Jakarta')->dayOfWeek;

        $schedules = DB::table('schedules')
                        ->leftJoin('classes', 'schedules.class_id', '=', 'classes.id')
                        ->leftJoin('rooms', 'schedules.room_id', '=', 'rooms.id')
                        ->leftJoin('subjects', 'schedules.subject_id', '=', 'subjects.id')
                        ->leftJoin('users', 'schedules.user_id', '=', 'users.id')
                        ->leftJoin('hari', 'schedules.day', '=', 'hari.id')
                        ->leftJoin('program_studies', 'subjects.program_study_id', '=', 'program_studies.id')
                    ->select('schedules.*', 'users.name', 'classes.class_name', 'rooms.room_name', 'subjects.subject_name', 'hari.day_english', 'program_studies.id as programstudy_id','program_studies.prodi_name')
                    ->where('hari.id', $day)
                    ->get();

        $array = [];
        foreach ($schedules as $schedule) {
            if (!empty($schedule->prodi_name)) {
                $array[$schedule->prodi_name][] = $schedule;
            }
        }

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'data' => $array
        ]);
    }
}