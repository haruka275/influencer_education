<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\NoticeController;
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\CurriculumProgressController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ユーザー用ルート
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    // お知らせ
    Route::get('notice', [NoticeController::class, 'index'])->name('notice.index');
    Route::get('notice/{id}', [NoticeController::class, 'show'])->name('notice.show');

    // プロフィール設定
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // 授業進捗（★追加済ルート）
    Route::get('curriculum-progress', [CurriculumProgressController::class, 'index'])->name('curriculum_progress.index');
    

});

// 管理者用ルート
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('notice', [AdminNoticeController::class, 'index'])->name('notice.index');
    Route::get('notice/create', [AdminNoticeController::class, 'create'])->name('notice.create');
    Route::post('notice', [AdminNoticeController::class, 'store'])->name('notice.store');
    Route::get('notice/{id}/edit', [AdminNoticeController::class, 'edit'])->name('notice.edit');
    Route::put('notice/{id}', [AdminNoticeController::class, 'update'])->name('notice.update');
    Route::delete('notice/{id}', [AdminNoticeController::class, 'destroy'])->name('notice.destroy');
});
