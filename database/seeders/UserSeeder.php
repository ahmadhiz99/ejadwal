<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
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
                    'name' => 'Super Admin',
                    'email' => 'super@gmail.com',
                    'email_verified_at' => null,
                    'password' => Hash::make('12345678'),
                    'nis' => null,
                    'status' => null,
                    'role_id' => 1,
                    'program_study_id' => 1,
                    'remember_token' => null,
                    'created_at' => null,
                    'updated_at' => null,
                ],
                [
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'email_verified_at' => null,
                    'password' => Hash::make('12345678'),
                    'nis' => null,
                    'status' => null,
                    'role_id' => 2,
                    'program_study_id' => 1,
                    'remember_token' => null,
                    'created_at' => null,
                    'updated_at' => null,
                ],
                [
                    'name' => 'Dosen 1, S.Kom., M.Koms',
                    'email' => 'dosen1@gmail.com',
                    'email_verified_at' => null,
                    'password' => Hash::make('12345678'),
                    'nis' => '321890',
                    'status' => '1',
                    'role_id' => 3,
                    'program_study_id' => 1,
                    'remember_token' => null,
                    'created_at' => Carbon::create('2024', '05', '18', '02', '36', '06'),
                    'updated_at' => null,
                ],
                [
                    'name' => 'Dosen 2, S.Kom., M.Koms',
                    'email' => 'dosen2@gmail.com',
                    'email_verified_at' => null,
                    'password' => Hash::make('12345678'),
                    'nis' => '321890',
                    'status' => '1',
                    'role_id' => 3,
                    'program_study_id' => 1,
                    'remember_token' => null,
                    'created_at' => Carbon::create('2024', '05', '18', '02', '36', '06'),
                    'updated_at' => null,
                ],
                [
                    'name' => 'Kaprodi, S.Kom., M.Koms',
                    'email' => 'kaprodi@gmail.com',
                    'email_verified_at' => null,
                    'password' => Hash::make('12345678'),
                    'nis' => '321890',
                    'status' => '1',
                    'role_id' => 4,
                    'program_study_id' => 1,
                    'remember_token' => null,
                    'created_at' => Carbon::create('2024', '05', '18', '02', '36', '06'),
                    'updated_at' => null,
                ],
                [
                    'name' => 'Mahassiswa',
                    'email' => 'mahasiswa@gmail.com',
                    'email_verified_at' => null,
                    'password' => Hash::make('12345678'),
                    'nis' => '123',
                    'status' => '1',
                    'role_id' => 5,
                    'program_study_id' => 1,
                    'remember_token' => null,
                    'created_at' => Carbon::create('2024', '05', '17', '19', '50', '24'),
                    'updated_at' => Carbon::create('2024', '05', '17', '19', '50', '24'),
                ],
            ]
        );
    }
}
