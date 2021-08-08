<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\ValidationRules\Rules\Currency;

class StoreAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'balance' => 'required|numeric|min:-1000000000|max:1000000000',
            'currency' => [
                'required',
                new Currency(),
            ],
        ];
    }
}
