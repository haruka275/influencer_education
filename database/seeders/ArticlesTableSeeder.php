<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArticlesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $articles = [
            [
                'title' => '初めてのお知らせ',
                'body' => 'これは最初のお知らせです。',
                'start_date' => $now->subDay()->toDateTimeString(),
                'end_date' => $now->copy()->addDays(7)->toDateTimeString(),
                'user_flag' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '重要なお知らせ',
                'body' => 'パスワード変更が必要です。',
                'start_date' => $now->copy()->subDays(2)->toDateTimeString(),
                'end_date' => $now->copy()->addDays(5)->toDateTimeString(),
                'user_flag' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '管理者限定のお知らせ',
                'body' => 'これはユーザーには非公開です。',
                'start_date' => $now->copy()->subDay()->toDateTimeString(),
                'end_date' => $now->copy()->addDays(3)->toDateTimeString(),
                'user_flag' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($articles as $article) {
            $exists = DB::table('articles')->where('title', $article['title'])->exists();

            if (! $exists) {
                DB::table('articles')->insert($article);
            }
        }
    }
}
