<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    public function rules(): array
    {
        $acceptedPronouns = collect(config('extension.pronouns'))->pluck('slug')->join(',');

        return [
            'occupation_id' => ['exists:occupations,id'],
            'color_id' => ['exists:settings_colors,id'],
            'effect_id' => ['exists:settings_effects,id'],
            'pronouns' => ['string', 'in:'.$acceptedPronouns],
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
