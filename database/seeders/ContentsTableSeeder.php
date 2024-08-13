<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Content; 

class ContentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Content::create([
            'name' => 'title',
            'code' => 'item1',
            'description' => 'UPY',
            'created_at' => '2024-01-31 13:05:19',
            'updated_at' => '2024-01-31 13:05:19',
        ]);
    }
}
?>