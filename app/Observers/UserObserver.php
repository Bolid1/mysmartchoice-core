<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use function event;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param User $user
     *
     * @return void
     */
    public function created(User $user): void
    {
        event(new Registered($user));
    }
}
