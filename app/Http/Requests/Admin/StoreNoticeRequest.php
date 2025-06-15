<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoticeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 権限チェックが不要なら true
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'posted_date' => 'required|date_format:Y-m-d H:i',
            'article_contents' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'posted_date.required' => '投稿日時は必須です。',
            'posted_date.date_format' => '投稿日時は「YYYY-MM-DD HH:MM」の形式で入力してください。',
            'article_contents.required' => '本文は必須です。',
        ];
    }
}
