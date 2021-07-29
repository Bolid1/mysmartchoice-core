<?php

declare(strict_types=1);

namespace App\Managers;

use App\Exceptions\RegisterUserFailedException;
use App\Models\User;
use App\Services\UserPasswordEncoder;

class UsersManager
{
    private UserPasswordEncoder $encoder;

    public function __construct(UserPasswordEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function register(array $attributes): User
    {
        $attributes['password'] = $this->encoder->encode($attributes['password']);

        $user = User::create($attributes);

        if (!$user->exists) {
            // @TODO: How can i test this?
            throw new RegisterUserFailedException($attributes);
        }

        return $user;
    }
}
