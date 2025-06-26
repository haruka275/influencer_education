<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\DeliveryTime;
use App\Models\Grade;

//基本クラスの継承
class CurriculumController extends Controller{
    //公開メソッドshowCurriculumListを定義　授業管理画面を表示するための処理
    public function showCurriculumList()
    {
        return view('admin.curriculum_list');//ビューテンプレートを表示する処理
    }

}