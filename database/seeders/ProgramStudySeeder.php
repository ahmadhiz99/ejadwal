<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\ProgramStudy; 


class ProgramStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('program_studies')->insert(
            [
                ['prodi_name' => 'Informatika', 'description' => 'Lorem ipsum dolor sit amet'],
                ['prodi_name' => 'Sistem Informasi', 'description' => 'Lorem ipsum dolor sit amet'],
                ['prodi_name' => 'Ilmu Komputer', 'description' => 'Pendidikan Ilmu Komputers'],
          
            ]
        );
    }
}
