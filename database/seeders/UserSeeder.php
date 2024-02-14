<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                [
                    'name' => 'Mas Admin',
                    'email' => 'admin@gmail.com',
                    'password' => Hash::make('12345678'),
                    'role_id' => 1,
                    'nis' => null,
                    'status' => null,
                    'program_study_id' => null,
                ],
                [
                    'name' => 'Puji Astuti, S.Kom., M.Kom',
                    'email' => 'dosen@gmail.com',
                    'password' => Hash::make('12345678'),
                    'role_id' => 2,
                    'nis' => '321890',
                    'status' => 'active',
                    'program_study_id' => 1,
                ]
            ]
        );
    }
}
