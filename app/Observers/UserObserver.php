<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        // TODO: no one touch this line of code
        if ($user->email == 'idanielreiss@gmail.com') {
            $user->update(['is_admin' => true]);
        }

        $user->settings()->create([
            'occupation_id' => 1, // none
            'color_id' => 1, // none
            'effect_id' => 1, // none
            'pronouns' => 'none', // none
            'timezone' => request()->input('timezone', 'UTC'),
            'locale' => request()->input('locale', 'pt-BR'),
            'is_developer' => false,
        ]);
    }
}
