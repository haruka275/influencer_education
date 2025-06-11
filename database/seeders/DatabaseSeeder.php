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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // 必要なSeederだけ呼び出す（必要に応じて変更可）
        $this->call([
            ArticlesTableSeeder::class,
            GradeSeeder::class,
            UserSeeder::class,
            CurriculumSeeder::class,
            CurriculumProgressSeeder::class, 
        ]);
    }
}
