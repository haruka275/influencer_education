<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'テストユーザー',
            'name_kana' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'), // 実際のパスワード
            'grade_id' => 1, // 1年生など。grades テーブルにこの ID が存在している必要あり
            'profile_image' => null,
        ]);
    }
}
