<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use function config;
use function count;

class OAuthTest extends TestCase
{
    public function testScopesKeysIntersection(): void
    {
        $plain = config('oauth.scopes.plain');
        $patterns = config('oauth.scopes.patterns');

        self::assertCount(count($plain) + count($patterns), $plain + $patterns);
        self::assertCount(count($plain) + count($patterns), config('oauth.scopes.keys'));
    }
}
