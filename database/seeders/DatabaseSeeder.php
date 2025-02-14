<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SysContentSeeder::class,
            HariTableSeeder::class,
            RoomsTableSeeder::class,
            ContentsTableSeeder::class,
            RoleSeeder::class,
            ProgramStudySeeder::class,
            SubjectsTableSeeder::class,
            ClassesTableSeeder::class,
            UserSeeder::class,
            SysMenusTableSeeder::class,
            TxMenuRolesTableSeeder::class,
            SchedulesTableSeeder::class
        ]);
    }
}
