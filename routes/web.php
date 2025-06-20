<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\TopController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CurriculumController as AdminCurriculumController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\User\CurriculumController as UserCurriculumController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 管理者用ルート
Route::prefix('admin')->name('admin.')->group(function () {
    // 認証不要ルート
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('show.login');
    Route::post('/login', [LoginController::class, 'store'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('show.register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    // 認証済み専用ルート
    Route::middleware('auth:admin')->group(function () {
        Route::get('/top', [TopController::class, 'showTop'])->name('show.top');
        Route::get('/curriculum_list', [CurriculumController::class, 'showCurriculumList'])->name('show.curriculum.list');
        Route::get('/article_list', [ArticleController::class, 'showArticleList'])->name('show.article.list');
        Route::get('/banner_edit', [BannerController::class, 'showBannerEdit'])->name('show.banner.edit');
    });
});

// ユーザー用ルート
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/curriculum_list', [UserCurriculumController::class, 'showCurriculumList'])->name('show.curriculum');
    Route::get('/delivery/{id}', [UserCurriculumController::class, 'showDelivery'])->name('show.delivery');
     // Ajaxで部分テンプレートを取得するルートを追加
    Route::get('/curriculum_list_partial', [UserCurriculumController::class, 'showCurriculumListPartial'])->name('curriculum_list_partial');
    
});
