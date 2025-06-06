<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'start_date')) {
                $table->dateTime('start_date')->nullable()->after('body');
            }

            if (!Schema::hasColumn('articles', 'end_date')) {
                $table->dateTime('end_date')->nullable()->after('start_date');
            }

            if (!Schema::hasColumn('articles', 'user_flag')) {
                $table->boolean('user_flag')->default(1)->after('end_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'start_date')) {
                $table->dropColumn('start_date');
            }

            if (Schema::hasColumn('articles', 'end_date')) {
                $table->dropColumn('end_date');
            }

            if (Schema::hasColumn('articles', 'user_flag')) {
                $table->dropColumn('user_flag');
            }
        });
    }
};
