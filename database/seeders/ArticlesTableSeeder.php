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
                'article_contents' => 'これは最初のお知らせです。',
                'start_date' => $now->copy()->subDay()->toDateTimeString(),         // 昨日
                'end_date' => $now->copy()->addDays(7)->toDateTimeString(),        // 7日後
                'user_flag' => 1,
                'posted_date' => $now->copy()->subDay()->toDateTimeString(),       // 昨日
                'created_at' => $now->copy(),
                'updated_at' => $now->copy(),
            ],
            [
                'title' => '重要なお知らせ',
                'article_contents' => 'パスワード変更が必要です。',
                'start_date' => $now->copy()->subDays(2)->toDateTimeString(),      // 2日前
                'end_date' => $now->copy()->addDays(5)->toDateTimeString(),        // 5日後
                'user_flag' => 1,
                'posted_date' => $now->copy()->subDays(2)->toDateTimeString(),     // 2日前
                'created_at' => $now->copy(),
                'updated_at' => $now->copy(),
            ],
            [
                'title' => '管理者限定のお知らせ',
                'article_contents' => 'これはユーザーには非公開です。',
                'start_date' => $now->copy()->subDay()->toDateTimeString(),        // 昨日
                'end_date' => $now->copy()->addDays(3)->toDateTimeString(),        // 3日後
                'user_flag' => 0,
                'posted_date' => $now->copy()->subDay()->toDateTimeString(),       // 昨日
                'created_at' => $now->copy(),
                'updated_at' => $now->copy(),
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
