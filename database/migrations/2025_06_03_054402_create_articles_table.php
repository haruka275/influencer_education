<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->string('title'); // 記事タイトル
            $table->text('body'); // 記事本文
            $table->dateTime('published_at')->nullable(); // 公開日時
            $table->boolean('user_flag')->default(1); // ユーザー用フラグ（1:表示）
            $table->timestamps(); // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
