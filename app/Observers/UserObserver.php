<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        $user->settings()->create([
            'occupation_id' => 1, // none
            'pronouns' => 'n/d',
        ]);
    }
}
