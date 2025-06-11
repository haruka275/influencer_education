<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id(); // ID（項番1）
            $table->string('title', 255); // カリキュラムタイトル（項番2）
            $table->string('thumbnail', 255)->nullable(); // サムネイル画像（項番3）
            $table->longText('description')->nullable(); // 説明文（項番4）
            $table->mediumText('video_url')->nullable(); // 動画URL（項番5）
            $table->tinyInteger('alway_delivery_flg')->default(0); // 常時公開フラグ（項番6）
            $table->unsignedBigInteger('grade_id'); // クラスID（項番7）
            $table->timestamps(); // 作成・更新日時（項番8・9）

            // 外部キー制約（gradesテーブルと紐づく）
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculums');
    }
}
