<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\Exceptions;
use RuntimeException;
use Throwable;

/**
 * Failed to register user exception.
 *
 * @TODO: Check error handling, how to save attributes in logs and how to customize http status code?
 */
class RegisterUserFailedException extends RuntimeException
{
    private array $attributes;

    public function __construct(array $attributes, Throwable $previous = null)
    {
        parent::__construct(
            'Failed to create user',
            Exceptions::FAILED_TO_CREATE_USER,
            $previous
        );

        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
