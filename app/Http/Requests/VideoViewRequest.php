<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoViewRequest extends FormRequest
{
    public function rules(): array {
        return [
            'video_id' => ['required', 'exists:videos,id'],
            'user_id' => ['required', 'exists:users,id'],
            'viewed_at' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
