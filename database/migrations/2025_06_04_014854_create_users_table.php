<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID（主キー, auto increment）
            $table->string('name', 255); // ユーザーネーム
            $table->string('name_kana', 255); // ユーザーネームカナ
            $table->string('email', 255)->unique(); // メールアドレス（ログインID）
            $table->string('password', 255); // ハッシュ化されたパスワード
            $table->string('profile_image', 255)->nullable(); // プロフィール画像（ファイル名）、任意
            $table->unsignedBigInteger('grade_id'); // 学年（外部キーは後ほど）
            $table->timestamps(); // created_at / updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
