<?php

declare(strict_types=1);

namespace App\Services;

use function config;
use function preg_match;
use function value;

class DynamicScopesBuilder
{
    private array $scopesPatterns;

    public function __construct()
    {
        $this->scopesPatterns = config('oauth.scopes.patterns');
    }

    public function detect(string $identifier): ?string
    {
        foreach ($this->scopesPatterns as $params) {
            $matches = [];
            if (preg_match($params['pattern'], $identifier, $matches)) {
                return value($params['description'], $matches);
            }
        }

        return null;
    }
}
