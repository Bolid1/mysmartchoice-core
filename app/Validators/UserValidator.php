<?php

declare(strict_types=1);

namespace App\Validators;

use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

class UserValidator
{
    #[
        ArrayShape(
            [
                'name' => "string",
                'email' => "string",
                'password' => "array"
            ]
        )
    ] public function getRulesForCreate(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::defaults()],
        ];
    }

    public function makeForCreate(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, $this->getRulesForCreate());
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @throws ValidationException
     */
    #[
        ArrayShape(
            [
                'name' => "string",
                'email' => "string",
                'password' => "string"
            ]
        )
    ] public function validateForCreate(array $data): array
    {
        return $this->makeForCreate($data)->validate();
    }
}
