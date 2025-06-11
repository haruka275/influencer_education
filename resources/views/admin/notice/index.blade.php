@extends('layouts.app')

@section('content')
<div class="admin-notice-container">

    {{-- ナビゲーションバー --}}
    <div class="admin-nav" style="background-color: #ADD8E6; padding: 20px 30px; display: flex; align-items: center;">
        <button class="nav-button" style="background-color: #808080; color: #FFFFFF; margin-right: 10px;">授業管理</button>
        <button class="nav-button" style="background-color: #808080; color: #FFFFFF; margin-right: 10px;">お知らせ管理</button>
        <button class="nav-button" style="background-color: #808080; color: #FFFFFF; margin-right: auto;">バナー管理</button>
        <span style="color: #FFFFFF; margin-right: 10px; cursor: pointer;">ログアウト</span>
        
    </div>

    {{-- 戻るリンク --}}
    <div class="mt-3" style="text-align: left;">
        <a href="{{ url()->previous() }}" class="back-link" style="text-decoration: none; color: #000000;">← 戻る</a>
    </div>

    {{-- タイトル --}}
    <h2 style="margin-top: 20px;">お知らせ一覧</h2>

    {{-- 新規登録ボタン --}}
    <div style="margin-top: 10px; text-align: left;">
        <a href="{{ route('admin.notice.create') }}" class="btn btn-primary" style="background-color: #ADD8E6; color: #FFFFFF; padding: 10px 20px; text-decoration: none; border-radius: 5px;">新規登録</a>
    </div>

    {{-- お知らせリスト --}}
    @if ($articles->isEmpty())
        <p style="margin-top: 20px;">現在、お知らせはありません。</p>
    @else
        <table class="notice-table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 10px; border-bottom: 2px solid #000000;">投稿日時</th>
                    <th style="text-align: left; padding: 10px; border-bottom: 2px solid #000000;">タイトル</th>
                    <th style="text-align: left; padding: 10px; border-bottom: 2px solid #000000;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #CCCCCC;">
                        {{ $article->posted_date ? \Carbon\Carbon::parse($article->posted_date)->format('Y年m月d日') : '未設定' }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #CCCCCC;">{{ $article->title }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #CCCCCC;">
                            <a href="{{ route('admin.notice.edit', $article->id) }}" class="btn btn-warning btn-sm" style="background-color: #ADD8E6; color: #FFFFFF; padding: 5px 10px; text-decoration: none; border-radius: 3px; margin-right: 5px;">変更する</a>
                            <form action="{{ route('admin.notice.destroy', $article->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="background-color: #FF0000; color: #FFFFFF; padding: 5px 10px; border: none; border-radius: 3px;">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
