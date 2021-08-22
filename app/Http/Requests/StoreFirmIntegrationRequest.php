<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Integration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\ValidationRules\Rules\Authorized;

class StoreFirmIntegrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'integration_id' => [
                'required',
                'int',
                Rule::exists(Integration::class, 'id'),
                new Authorized('install', Integration::class),
            ],
        ];
    }
}
