<?php

declare(strict_types=1);

use App\Models\Firm;

return [
    'plain' => $plain = [
        'view-firms' => 'View list of all your firms',
        'view-firms-users' => 'View list of all users from all of your firms',
        'create-firms' => 'View list of all your firms',
        'update-firms' => 'Modify title of any your firms',
        'destroy-firms' => 'Delete any of your firms',
    ],

    'patterns' => $patterns = [
        'view-firm-{firm}' => [
            'pattern' => '/^view-firm-(?P<firm>\d+)$/',
            'description' => static fn ($matches = []) => \str_replace(
                '{firm}',
                isset($matches['firm'])
                    ? \optional(Firm::select(['id', 'title'])->find((int)$matches['firm']))->title
                    : '{firm}',
                'View title and meta of firm {firm}'
            ),
        ],
        'update-firm-{firm}' => [
            'pattern' => '/^update-firm-(?P<firm>\d+)$/',
            'description' => static fn ($matches = []) => \str_replace(
                '{firm}',
                isset($matches['firm'])
                    ? \optional(Firm::select(['id', 'title'])->find((int)$matches['firm']))->title
                    : '{firm}',
                'Modify title of firm {firm}'
            ),
        ],
        'delete-firm-{firm}' => [
            'pattern' => '/^delete-firm-(?P<firm>\d+)$/',
            'description' => static fn ($matches = []) => \str_replace(
                '{firm}',
                isset($matches['firm'])
                    ? \optional(Firm::select(['id', 'title'])->find((int)$matches['firm']))->title
                    : '{firm}',
                'Delete firm {firm}'
            ),
        ],
        'view-firm-{firm}-users' => [
            'pattern' => '/^view-firm-(?P<firm>\d+)-users$/',
            'description' => static fn ($matches = []) => \str_replace(
                '{firm}',
                isset($matches['firm'])
                // FixMe: Should check current user rights
                    ? \optional(Firm::select(['id', 'title'])->find((int)$matches['firm']))->title
                    : '{firm}',
                'View all users in firm {firm}'
            ),
        ],
    ],

    'keys' => \array_merge(
        \array_keys($plain),
        \array_keys($patterns),
    ),
];
