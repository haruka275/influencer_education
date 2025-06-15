<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoticeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認可が必要なら条件指定
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'posted_date' => 'required|date_format:Y-m-d\TH:i',
            'article_contents' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'posted_date.required' => '投稿日時は必須です。',
            'posted_date.date_format' => '投稿日時は「YYYY-MM-DDTHH:MM」の形式で入力してください。',
            'article_contents.required' => '本文は必須です。',
        ];
    }
}
