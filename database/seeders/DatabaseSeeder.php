<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    $this->call(GradeSeeder::class);       // まず学年データを投入
    $this->call(CurriculumSeeder::class);  // その後カリキュラムデータを投入
}
}