<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'occupation_id' => ['required', 'exists:occupations'],
            'pronouns' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return request()->user()->id == $this->input('user_id');
    }
}
