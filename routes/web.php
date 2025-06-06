<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\NoticeController;
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ユーザー用ルート
Route::prefix('user')->name('user.')->group(function () {
    Route::get('notice/{id}', [NoticeController::class, 'show'])->name('notice.show');
});

// 管理者用ルート
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('notice', [AdminNoticeController::class, 'index'])->name('notice.index');
    Route::get('notice/create', [AdminNoticeController::class, 'create'])->name('notice.create');   // 追加
    Route::get('notice/{id}/edit', [AdminNoticeController::class, 'edit'])->name('notice.edit');   // 追加
    Route::delete('notice/{id}', [AdminNoticeController::class, 'destroy'])->name('notice.destroy'); // 追加
});
