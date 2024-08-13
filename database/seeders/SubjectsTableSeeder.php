<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                'code' => 'S1',
                'subject_name' => 'Pengenalan Informatika',
                'sks' => 2,
                'semester' => 1,
                'program_study_id' => 1,
            ],
        ]);
    }
}

