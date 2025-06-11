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
        Schema::create('curriculum_progresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curriculum_id'); // カリキュラムID
            $table->unsignedBigInteger('user_id'); // ユーザーID
            $table->boolean('clear_flg')->default(0); // 受講完了フラグ（1:受講済、0:未受講）
            $table->timestamp('last_learned_at')->nullable(); // 最終学習日時
            $table->timestamps();

            // 外部キー制約（削除時に関連データも削除）
            $table->foreign('curriculum_id')
                  ->references('id')
                  ->on('curriculums')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculum_progresses');
    }
};
