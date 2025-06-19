<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CurriculumSeeder extends Seeder
{
 public function run()
    {
        // 例えば、学年ID=1を割り当てる
        $gradeId = 1;

        $curriculumId1 = DB::table('curriculums')->insertGetId([
            'title' => 'サンプル授業1',
            'alway_delivery_flg' => 1,
            'grade_id' => $gradeId,
            'thumbnail' => '/images/sample.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $curriculumId2 = DB::table('curriculums')->insertGetId([
            'title' => 'サンプル授業2',
            'alway_delivery_flg' => 0,
            'grade_id' => $gradeId,
            'thumbnail' => '/images/sample.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('delivery_times')->insert([
            'curriculums_id' => $curriculumId2,
            'delivery_from' => Carbon::now()->addDay(),
            'delivery_to' => Carbon::now()->addDays(4),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $curriculumId2 = DB::table('curriculums')->insertGetId([
            'title' => 'サンプル授業3',
            'alway_delivery_flg' => 0,
            'grade_id' => $gradeId,
            'thumbnail' => '/images/sample.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('delivery_times')->insert([
            'curriculums_id' => $curriculumId2,
            'delivery_from' => Carbon::now()->addDay(),
            'delivery_to' => Carbon::now()->addDays(4),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $curriculumId2 = DB::table('curriculums')->insertGetId([
            'title' => 'サンプル授業4',
            'alway_delivery_flg' => 0,
            'grade_id' => $gradeId,
            'thumbnail' => '/images/sample.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('delivery_times')->insert([
            'curriculums_id' => $curriculumId2,
            'delivery_from' => Carbon::now()->addDay(),
            'delivery_to' => Carbon::now()->addDays(4),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $curriculumId2 = DB::table('curriculums')->insertGetId([
            'title' => 'サンプル授業5',
            'alway_delivery_flg' => 0,
            'grade_id' => $gradeId,
            'thumbnail' => '/images/sample.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('delivery_times')->insert([
            'curriculums_id' => $curriculumId2,
            'delivery_from' => Carbon::now()->addDay(30),
            'delivery_to' => Carbon::now()->addDays(35),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $curriculumId2 = DB::table('curriculums')->insertGetId([
            'title' => 'サンプル授業6',
            'alway_delivery_flg' => 0,
            'grade_id' => $gradeId,
            'thumbnail' => '/images/sample.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('delivery_times')->insert([
            'curriculums_id' => $curriculumId2,
            'delivery_from' => Carbon::now()->addDay(),
            'delivery_to' => Carbon::now()->addDays(4),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }


}
