<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Hash;

/**
 * Service for manage user password feature.
 */
class UserPasswordEncoder
{
    /**
     * @param string $plainPassword
     *
     * @return string Encoded plain password to store in DB
     */
    public function encode(string $plainPassword): string
    {
        return Hash::make($plainPassword);
    }

    /**
     * @param string $plainPassword
     * @param string $hashedPassword
     *
     * @return bool Does $plainPassword matching against $password hash?
     */
    //public function verify(string $plainPassword, string $hashedPassword): bool
    //{
    //    return $this->manager->check($plainPassword, $hashedPassword);
    //}
}
