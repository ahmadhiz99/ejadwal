<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;
use App\Models\Classes; // Pastikan nama model Anda sesuai

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            ['class_name' => 'Kelas A', 'code' => 'A1', 'description' => 'Class A number 1', 'program_study_id' => 1],
            ['class_name' => 'Kelas B', 'code' => 'B1', 'description' => 'Class B number 1', 'program_study_id' => 1],
            ['class_name' => 'test clas', 'code' => '1', 'description' => 'asdasd', 'program_study_id' => 1],
            ['class_name' => 'CLASS D', 'code' => '12', 'description' => 'aaaa', 'program_study_id' => 2],
        ];

        foreach ($classes as $class) {
            Classes::create($class);
        }
    }
}

?>