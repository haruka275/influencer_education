<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->nullable(false);//カリキュラムタイトル
            $table->string('thumbnail',255)->nullable();//カリキュラムサムネイル
            $table->longText('description')->nullable();//カリキュラム説明文
            $table->mediumText('video_url')->nullable();//動画URL
            $table->tinyInteger('alway_delivery_flg')->default(0); //常時公開フラグ
            $table->unsignedInteger('grade_id')->nullable(false);//クラスID,grades テーブルのidと紐づく
            $table->timestamps();//created_at,updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculums');
    }
};
