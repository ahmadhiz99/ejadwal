<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Room; // Pastikan nama model Anda sesuai

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            ['room_name' => 'ROOM 1', 'description' => 'RUANGAN LT 111', 'is_active' => 0],
            ['room_name' => 'ROOM 2', 'description' => 'RUANGAN LT 2', 'is_active' => 1],
            ['room_name' => 'ROOM 3', 'description' => 'RUANGAN LT 3', 'is_active' => 1],
            ['room_name' => 'LAB', 'description' => 'LABORAT', 'is_active' => 1],
            ['room_name' => 'AULA', 'description' => 'AULA UTAMA', 'is_active' => 0],
            ['room_name' => 'RUANGAN BASEMENT', 'description' => 'Ruangan Tambahan', 'is_active' => 0],
            ['room_name' => 'tes', 'description' => 'tes', 'is_active' => 0],
            ['room_name' => 'aa', 'description' => 'aa', 'is_active' => 1],
            ['room_name' => 'aa', 'description' => 'aa', 'is_active' => 1],
            ['room_name' => 'bb', 'description' => 'aa', 'is_active' => 1],
            ['room_name' => 'tes', 'description' => 'tes', 'is_active' => 0],
            ['room_name' => 'bb', 'description' => 'aa', 'is_active' => 0],
            ['room_name' => 'bb', 'description' => 'aa', 'is_active' => 0],
            ['room_name' => 'bb', 'description' => 'aa', 'is_active' => 0],
            ['room_name' => 'bb', 'description' => 'aa', 'is_active' => 1],
        ];

        foreach ($rooms as $data) {
            Room::create($data);
        }
    }
}
