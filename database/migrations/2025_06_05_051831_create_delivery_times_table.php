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
        Schema::create('delivery_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('curriculums_id')->nullable(false);//カリキュラムid,curriculumsテーブルのidと紐づく
            $table->dateTime('delivery_from')->nullable(false);//公開開始日
            $table->dateTime('delivery_to')->nullable(false);//公開終了日
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
        Schema::dropIfExists('delivery_times');
    }
};
