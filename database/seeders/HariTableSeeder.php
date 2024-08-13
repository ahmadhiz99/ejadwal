<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Hari; // Pastikan nama model Anda sesuai

class HariTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hari = [
            ['id' => 1, 'day_name' => 'Senin', 'day_english' => 'Sunday'],
            ['id' => 2, 'day_name' => 'Selasa', 'day_english' => 'Monday'],
            ['id' => 3, 'day_name' => 'Rabu', 'day_english' => 'Tuesday'],
            ['id' => 4, 'day_name' => 'Kamis', 'day_english' => 'Wednesday'],
            ['id' => 5, 'day_name' => 'Jumat', 'day_english' => 'Thursday'],
            ['id' => 6, 'day_name' => 'Sabtu', 'day_english' => 'Friday'],
            ['id' => 7, 'day_name' => 'Minggu', 'day_english' => 'Saturday'],
        ];

        foreach ($hari as $data) {
            DB::table('hari')->insert($data);
        }
    }
}
