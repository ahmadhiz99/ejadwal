<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role; // Pastikan nama model Anda sesuai

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['role_name' => 'super', 'level' => 1],
            ['role_name' => 'admin', 'level' => 2],
            ['role_name' => 'dosen', 'level' => 3],
            ['role_name' => 'kaprodi', 'level' => 4],
            ['role_name' => 'mahasiswa', 'level' => 5],
        ];

        foreach ($roles as $data) {
            Role::create($data);
        }
    }
}

