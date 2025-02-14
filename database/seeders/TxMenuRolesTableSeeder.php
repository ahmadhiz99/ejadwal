<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TxMenuRolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tx_menu_roles')->insert([
            ['menu_id' => 1, 'role_id' => 1, 'description' => null, 'is_active' => '1', 'created_at' => null, 'updated_at' => null],
            ['menu_id' => 95, 'role_id' => 1, 'description' => null, 'is_active' => '1', 'created_at' => null, 'updated_at' => null],
            ['menu_id' => 2, 'role_id' => 1, 'description' => null, 'is_active' => '1', 'created_at' => '2024-05-19 17:23:18', 'updated_at' => '2024-05-19 17:23:18'],
            ['menu_id' => 96, 'role_id' => 1, 'description' => null, 'is_active' => '1', 'created_at' => null, 'updated_at' => null],
            ['menu_id' => 97, 'role_id' => 1, 'description' => null, 'is_active' => '1', 'created_at' => null, 'updated_at' => null],
            ['menu_id' => 3, 'role_id' => 1, 'description' => null, 'is_active' => '1', 'created_at' => null, 'updated_at' => null],
            ['menu_id' => 1, 'role_id' => 2, 'description' => 'tes', 'is_active' => '1', 'created_at' => '2024-07-23 16:04:16', 'updated_at' => '2024-07-23 16:04:16'],
            ['menu_id' => 2, 'role_id' => 2, 'description' => null, 'is_active' => '1', 'created_at' => '2024-07-23 16:06:46', 'updated_at' => '2024-07-23 16:06:46'],
            ['menu_id' => 6, 'role_id' => 2, 'description' => null, 'is_active' => '1', 'created_at' => '2024-07-23 16:07:01', 'updated_at' => '2024-07-23 16:07:01'],
            ['menu_id' => 4, 'role_id' => 2, 'description' => null, 'is_active' => '1', 'created_at' => '2024-07-23 16:08:23', 'updated_at' => '2024-07-23 16:08:23'],
            ['menu_id' => 107, 'role_id' => 2, 'description' => null, 'is_active' => '1', 'created_at' => '2024-07-23 16:08:53', 'updated_at' => '2024-07-23 16:08:53'],
            ['menu_id' => 95, 'role_id' => 2, 'description' => null, 'is_active' => '1', 'created_at' => '2024-07-23 16:09:43', 'updated_at' => '2024-07-23 16:09:43'],
            ['menu_id' => 98, 'role_id' => 2, 'description' => null, 'is_active' => '1', 'created_at' => '2024-07-23 16:09:57', 'updated_at' => '2024-07-23 16:09:57'],
            ['menu_id' => 99, 'role_id' => 2, 'description' => null, 'is_active' => '1', 'created_at' => '2024-07-23 16:10:19', 'updated_at' => '2024-07-23 16:10:19'],
            // ['menu_id' => 2, 'role_id' => 3, 'description' => 'tess dosen', 'is_active' => '1', 'created_at' => '2024-07-23 20:06:56', 'updated_at' => '2024-07-23 20:06:56'],
            // ['menu_id' => 4, 'role_id' => 3, 'description' => 'tess dosen', 'is_active' => '1', 'created_at' => '2024-07-23 20:06:56', 'updated_at' => '2024-07-23 20:06:56'],
            // ['menu_id' => 6, 'role_id' => 3, 'description' => 'tess dosen', 'is_active' => '1', 'created_at' => '2024-07-23 20:06:56', 'updated_at' => '2024-07-23 20:06:56'],
            // ['menu_id' => 107, 'role_id' => 3, 'description' => 'tess dosen', 'is_active' => '1', 'created_at' => '2024-07-23 20:06:56', 'updated_at' => '2024-07-23 20:06:56'],
            ['menu_id' => 5, 'role_id' => 1, 'description' => 'super', 'is_active' => '1', 'created_at' => '2024-07-23 21:34:01', 'updated_at' => '2024-07-23 21:34:01'],
            ['menu_id' => 7, 'role_id' => 1, 'description' => 'super', 'is_active' => '1', 'created_at' => '2024-07-23 21:34:01', 'updated_at' => '2024-07-23 21:34:01'],
            ['menu_id' => 8, 'role_id' => 1, 'description' => 'super', 'is_active' => '1', 'created_at' => '2024-07-23 21:34:01', 'updated_at' => '2024-07-23 21:34:01'],
            ['menu_id' => 9, 'role_id' => 1, 'description' => 'super', 'is_active' => '1', 'created_at' => '2024-07-23 21:34:01', 'updated_at' => '2024-07-23 21:34:01'],
            ['menu_id' => 105, 'role_id' => 1, 'description' => 'superr', 'is_active' => '1', 'created_at' => '2024-07-23 21:35:04', 'updated_at' => '2024-07-23 21:35:04'],
            ['menu_id' => 106, 'role_id' => 1, 'description' => 'superr', 'is_active' => '1', 'created_at' => '2024-07-23 21:35:04', 'updated_at' => '2024-07-23 21:35:04'],
            ['menu_id' => 5, 'role_id' => 2, 'description' => 'admin', 'is_active' => '1', 'created_at' => '2024-07-23 21:35:04', 'updated_at' => '2024-07-23 21:35:04'],
            ['menu_id' => 9, 'role_id' => 2, 'description' => 'admin', 'is_active' => '1', 'created_at' => '2024-07-23 21:35:04', 'updated_at' => '2024-07-23 21:35:04'],
            ['menu_id' => 5, 'role_id' => 3, 'description' => 'dosen', 'is_active' => '1', 'created_at' => '2024-07-23 21:35:04', 'updated_at' => '2024-07-23 21:35:04'],
            ['menu_id' => 5, 'role_id' => 4, 'description' => 'kaprodi', 'is_active' => '1', 'created_at' => '2024-07-23 21:35:04', 'updated_at' => '2024-07-23 21:35:04'],
            ['menu_id' => 1, 'role_id' => 4, 'description' => null, 'is_active' => '1', 'created_at' => null, 'updated_at' => null],
            ['menu_id' => 1, 'role_id' => 5, 'description' => null, 'is_active' => '1', 'created_at' => null, 'updated_at' => null],

        ]);
    }
}
