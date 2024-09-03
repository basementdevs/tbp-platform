<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    public function rules(): array
    {
        $acceptedPronouns = collect(config('extension.pronouns'))->pluck('slug')->join(',');

        return match ($this->method()) {
            'PUT' => $this->putValidation($acceptedPronouns),
            'PATCH' => $this->patchValidation($acceptedPronouns)
        };
    }

    /**
     * @return array[]
     */
    public function patchValidation(string $acceptedPronouns): array
    {
        return [
            'occupation_id' => ['exists:occupations,id'],
            'channel_id' => ['string'],
            'enabled' => ['boolean'],
            'color_id' => ['exists:settings_colors,id'],
            'effect_id' => ['exists:settings_effects,id'],
            'timezone' => ['string'],
            'locale' => ['string'],
            'pronouns' => ['string', 'in:'.$acceptedPronouns],
        ];
    }

    /**
     * @return array[]
     */
    public function putValidation(string $acceptedPronouns): array
    {
        return [
            'occupation_id' => ['exists:occupations,id'],
            'channel_id' => ['required', 'string'],
            'enabled' => ['required'],
            'color_id' => ['exists:settings_colors,id'],
            'effect_id' => ['exists:settings_effects,id'],
            'timezone' => ['string'],
            'locale' => ['string'],
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
