<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Integration;
use App\Models\OAuthClient as Client;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use function auth;
use function config;
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
            'settings.oauth2_client_id' => [
                'required_if:settings.auth,'.Integration::AUTH_OAUTH2,
                'string',
                'uuid',
                Rule::exists(Client::class, 'id')->where(function (Builder $query) {
                    $id = auth()->id();

                    return $id ? $query->where('user_id', $id) : $query->whereRaw('1=0');
                }),
            ],
            'settings.oauth2_scopes' => [
                'required_if:settings.auth,'.Integration::AUTH_OAUTH2,
                'array',
            ],
            'settings.oauth2_scopes.*' => 'string|in:*,'.implode(',', config('oauth.scopes.keys')),
        ];
    }
}
