<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\OAuth;

use App\Http\Controllers\Controller;
use function config;
use function value;

class ScopesController extends Controller
{
    public function index(): array
    {
        $scopes = [];

        foreach (config('oauth.scopes.plain') as $key => $item) {
            $scopes[] = [
                'key' => $key,
                'description' => $item,
            ];
        }

        foreach (config('oauth.scopes.patterns') as $key => $item) {
            $scopes[] = [
                'key' => $key,
                'description' => value($item['description']),
            ];
        }

        return $scopes;
    }
}
