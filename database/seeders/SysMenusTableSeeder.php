<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SysMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Dashboard', 'code' => 'D1', 'parent' => '0', 'icon' => 'bx-home', 'route' => 'dashboard', 'activeRoute' => NULL, 'is_active' => 1, 'created_at' => '2024-05-15 04:19:01', 'updated_at' => '2024-05-15 04:19:01'],
            ['id' => 2, 'name' => 'Prodi', 'code' => 'A1', 'parent' => '0', 'icon' => 'bx-buildings', 'route' => '', 'activeRoute' => '', 'is_active' => 1, 'created_at' => '2024-01-31 06:13:00', 'updated_at' => '2024-01-31 06:13:00'],
            ['id' => 3, 'name' => 'Sys Menu', 'code' => 'A1', 'parent' => '0', 'icon' => 'bx-grid', 'route' => 'menu.table', 'activeRoute' => 'menu.menus', 'is_active' => 1, 'created_at' => '2024-01-31 06:13:00', 'updated_at' => '2024-01-31 06:13:00'],
            ['id' => 4, 'name' => 'Program Studi', 'code' => 'A1', 'parent' => '2', 'icon' => NULL, 'route' => 'programstudies.table', 'activeRoute' => '', 'is_active' => 1, 'created_at' => '2024-01-31 06:13:00', 'updated_at' => '2024-01-31 06:13:00'],
            ['id' => 5, 'name' => 'Akademik', 'code' => 'A1', 'parent' => '0', 'icon' => 'bx-calendar', 'route' => '', 'activeRoute' => '', 'is_active' => 1, 'created_at' => '2024-01-31 06:13:00', 'updated_at' => '2024-01-31 06:13:00'],
            ['id' => 6, 'name' => 'Dosen', 'code' => 'A1', 'parent' => '2', 'icon' => NULL, 'route' => 'lecturer.table', 'activeRoute' => 'lecturer.lecturers', 'is_active' => 1, 'created_at' => '2024-01-31 06:13:00', 'updated_at' => '2024-05-15 07:52:59'],
            ['id' => 7, 'name' => 'Mata Kuliah', 'code' => 'A1', 'parent' => '2', 'icon' => NULL, 'route' => 'subject.table', 'activeRoute' => '', 'is_active' => 1, 'created_at' => '2024-01-31 06:13:00', 'updated_at' => '2024-08-02 02:59:36'],
            ['id' => 8, 'name' => 'Ruangan', 'code' => 'A1', 'parent' => '2', 'icon' => NULL, 'route' => 'room.table', 'activeRoute' => 'room.rooms', 'is_active' => 1, 'created_at' => '2024-01-31 06:13:00', 'updated_at' => '2024-08-01 16:08:48'],
            ['id' => 9, 'name' => 'Jadwal', 'code' => 'A1', 'parent' => '5', 'icon' => NULL, 'route' => 'schedule.table', 'activeRoute' => 'room.rooms', 'is_active' => 1, 'created_at' => '2024-01-31 06:13:00', 'updated_at' => '2024-07-23 16:46:23'],
            ['id' => 95, 'name' => 'Sys User', 'code' => 'U', 'parent' => '0', 'icon' => 'bx-user', 'route' => 'user.index', 'activeRoute' => NULL, 'is_active' => 1, 'created_at' => '2024-05-15 08:23:41', 'updated_at' => '2024-05-17 13:26:04'],
            ['id' => 96, 'name' => 'List Menu', 'code' => 'M1', 'parent' => '3', 'icon' => NULL, 'route' => 'menu.table', 'activeRoute' => 'menu.menus', 'is_active' => 1, 'created_at' => '2024-05-17 13:19:12', 'updated_at' => '2024-05-17 13:19:12'],
            ['id' => 97, 'name' => 'Transaction Menu', 'code' => 'M2', 'parent' => '3', 'icon' => NULL, 'route' => 'txmenu.table', 'activeRoute' => 'menu.menus', 'is_active' => 1, 'created_at' => '2024-05-17 13:20:34', 'updated_at' => '2024-05-17 13:20:34'],
            ['id' => 98, 'name' => 'List Role', 'code' => 'U1', 'parent' => '95', 'icon' => NULL, 'route' => 'role.table', 'activeRoute' => NULL, 'is_active' => 1, 'created_at' => '2024-05-17 13:49:16', 'updated_at' => '2024-05-17 14:18:05'],
            ['id' => 99, 'name' => 'List User', 'code' => 'U2', 'parent' => '95', 'icon' => NULL, 'route' => 'user.table', 'activeRoute' => NULL, 'is_active' => 1, 'created_at' => '2024-05-17 13:50:09', 'updated_at' => '2024-05-17 13:50:09'],
            ['id' => 105, 'name' => 'Sys Content', 'code' => 'SC', 'parent' => '0', 'icon' => 'bx-food-menu', 'route' => '', 'activeRoute' => '', 'is_active' => 1, 'created_at' => '2024-05-17 16:41:27', 'updated_at' => '2024-05-17 16:41:27'],
            ['id' => 106, 'name' => 'List Contents', 'code' => 'SC1', 'parent' => '105', 'icon' => NULL, 'route' => 'content.table', 'activeRoute' => NULL, 'is_active' => 1, 'created_at' => '2024-05-17 16:42:14', 'updated_at' => '2024-05-17 17:51:07'],
            ['id' => 107, 'name' => 'Class', 'code' => 'M3', 'parent' => '2', 'icon' => NULL, 'route' => 'class.table', 'activeRoute' => NULL, 'is_active' => 1, 'created_at' => '2024-05-19 03:11:09', 'updated_at' => '2024-05-19 03:11:09'],
      ];


        DB::table('sys_menu')->insert($data);
    }
}
