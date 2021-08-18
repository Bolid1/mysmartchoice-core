<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Integration;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Laravel\Passport\Client;
use function auth;
use function implode;

class StoreIntegrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:100',
            'description' => 'required|string|min:5|max:100',
            'settings.auth' => 'required|string|in:'.implode(',', [
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
        ];
    }
}
