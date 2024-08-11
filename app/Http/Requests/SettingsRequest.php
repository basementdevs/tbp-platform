<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'occupation_id' => ['required', 'exists:occupations,id'],
            'pronouns' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['user_id' => $this->user()->id]);
    }

    public function authorize(): bool
    {
        return request()->user()->id == $this->input('user_id');
    }
}
