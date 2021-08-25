<?php

declare(strict_types=1);

use App\Models\Firm;

return [
    'patterns' => [
        'view-firm' => [
            'pattern' => '/^view-firm-(?P<firm>\d+)$/',
            'description' => static fn ($matches) => \str_replace(
                '{firm}',
                isset($matches['firm'])
                    ? \optional(Firm::select(['id', 'title'])->find((int)$matches['firm']))->title
                    : '',
                'View title and meta of firm {firm}'
            ),
        ],
        'update-firm' => [
            'pattern' => '/^update-firm-(?P<firm>\d+)$/',
            'description' => static fn ($matches) => \str_replace(
                '{firm}',
                isset($matches['firm'])
                    ? \optional(Firm::select(['id', 'title'])->find((int)$matches['firm']))->title
                    : '',
                'Modify title of firm {firm}'
            ),
        ],
        'delete-firm' => [
            'pattern' => '/^delete-firm-(?P<firm>\d+)$/',
            'description' => static fn ($matches) => \str_replace(
                '{firm}',
                isset($matches['firm'])
                    ? \optional(Firm::select(['id', 'title'])->find((int)$matches['firm']))->title
                    : '',
                'Delete firm {firm}'
            ),
        ],
        'view-firm-users' => [
            'pattern' => '/^view-firm-(?P<firm>\d+)-users$/',
            'description' => static fn ($matches) => \str_replace(
                '{firm}',
                isset($matches['firm'])
                    ? \optional(Firm::select(['id', 'title'])->find((int)$matches['firm']))->title
                    : '',
                'View all users in firm {firm}'
            ),
        ],
    ],
];
