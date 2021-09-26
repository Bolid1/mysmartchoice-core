<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Integration;
use Illuminate\Foundation\Http\FormRequest;
use function implode;

class UpdateIntegrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'string|min:5|max:100',
            'description' => 'string|min:5|max:100',
            'settings.auth' => 'string|in:'.implode(',', [
                    Integration::AUTH_OAUTH2,
            ]),
            'settings.authorize_uri' => [
                'required_if:settings.auth,'.Integration::AUTH_OAUTH2,
                'string',
                'url',
            ],
        ];
    }
}
