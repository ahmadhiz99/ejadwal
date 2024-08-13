<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Schedule;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedules = [
            ['start_time' => '08:30:00', 'end_time' => '10:00:00', 'day' => 1, 'status' => 5, 'class_id' => 4, 'room_id' => 1, 'subject_id' => 2, 'user_id' => 15],
            ['start_time' => '08:30:00', 'end_time' => '10:00:00', 'day' => 2, 'status' => 1, 'class_id' => 2, 'room_id' => 10, 'subject_id' => 1, 'user_id' => 3],
            ['start_time' => '08:30:00', 'end_time' => '08:30:00', 'day' => 3, 'status' => null, 'class_id' => 2, 'room_id' => 2, 'subject_id' => 4, 'user_id' => 3],
        ];

        foreach ($schedules as $data) {
            Schedule::create($data);
        }
    }
}
