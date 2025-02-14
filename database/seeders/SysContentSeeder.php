<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class SysContentSeeder extends Seeder
{
    public function run()
    {
        $contents = [
            ['name' => 'title', 'value' => 'APLIKASI E-JADWAL FAKULTAS SAINS & TEKNOLOGI', 'description' => 'aaaa', 'url' => null, 'is_active' => 1, 'created_at' => null, 'updated_at' => '2024-05-18 01:13:44'],
            ['name' => 'title_2', 'value' => 'E-Jadwal', 'description' => '', 'url' => null, 'is_active' => 0, 'created_at' => null, 'updated_at' => null],
            ['name' => 'title_3', 'value' => 'Fakultas Sains dan Teknologi', 'description' => 'dasd', 'url' => null, 'is_active' => 1, 'created_at' => '2024-05-18 01:15:21', 'updated_at' => '2024-05-18 01:15:21'],
            ['name' => 'logo', 'value' => '/assets/images/upy.png', 'description' => 'dasd', 'url' => null, 'is_active' => 1, 'created_at' => '2024-05-18 01:15:21', 'updated_at' => '2024-05-18 01:15:21'],
        ];

        // Insert all records into the 'sys_content' table
        DB::table('sys_content')->insert($contents);
    }
}
