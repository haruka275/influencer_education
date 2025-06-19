<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    public function showBannerEdit()
    {
        //バナー情報をDBから取得
        $banners = Banner::all();

        return view('admin.banner_edit',compact('banners'));
        //$bannersを配列に変換しビュー(admin/banner_edit.blade.php)に渡す.ビュー内で $banners 変数が使えるようになる
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/banner', 'public');
                $dbPath = 'storage/' . $path;

                $banner = new Banner();
                $banner->image_path = $dbPath;
                $banner->save();
            }
        }

        // 編集画面のURLにリダイレクトし、最新のバナー画像を表示させる
        return redirect()->route('admin.show.banner.edit')->with('success', '画像を保存しました。');
    }
}
