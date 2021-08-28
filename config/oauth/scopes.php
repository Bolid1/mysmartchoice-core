<?php

declare(strict_types=1);

$makeDescriptionCallback = static fn ($description) => static function ($matches = []) use ($description) {
    if (!isset($matches['firm']) || !\is_numeric($matches['firm'])) {
        return $description;
    }

    $user = \Illuminate\Support\Facades\Auth::user();
    if (!($user instanceof \App\Models\User)) {
        return $description;
    }

    $firm = $user->firms()->find($matches['firm']);
    if (!($firm instanceof \App\Models\Firm)) {
        return $description;
    }

    return \str_replace('{firm}', $firm->title, $description);
};

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
            'description' => $makeDescriptionCallback('View title and meta of firm {firm}'),
        ],
        'update-firm-{firm}' => [
            'pattern' => '/^update-firm-(?P<firm>\d+)$/',
            'description' => $makeDescriptionCallback('Modify title of firm {firm}'),
        ],
        'delete-firm-{firm}' => [
            'pattern' => '/^delete-firm-(?P<firm>\d+)$/',
            'description' => $makeDescriptionCallback('Delete firm {firm}'),
        ],
        'view-firm-{firm}-users' => [
            'pattern' => '/^view-firm-(?P<firm>\d+)-users$/',
            'description' => $makeDescriptionCallback('View all users in firm {firm}'),
        ],
        'view-firm-{firm}-accounts' => [
            'pattern' => '/^view-firm-(?P<firm>\d+)-accounts$/',
            'description' => $makeDescriptionCallback('View any account in firm {firm}'),
        ],
        'create-firm-{firm}-accounts' => [
            'pattern' => '/^create-firm-(?P<firm>\d+)-accounts$/',
            'description' => $makeDescriptionCallback('Create account in firm {firm}'),
        ],
        'update-firm-{firm}-accounts' => [
            'pattern' => '/^update-firm-(?P<firm>\d+)-accounts$/',
            'description' => $makeDescriptionCallback('Update any account in firm {firm}'),
        ],
        'delete-firm-{firm}-accounts' => [
            'pattern' => '/^delete-firm-(?P<firm>\d+)-accounts$/',
            'description' => $makeDescriptionCallback('Delete any account in firm {firm}'),
        ],
        'restore-firm-{firm}-accounts' => [
            'pattern' => '/^restore-firm-(?P<firm>\d+)-accounts$/',
            'description' => $makeDescriptionCallback('Restore any account in firm {firm}'),
        ],
        'force_delete-firm-{firm}-accounts' => [
            'pattern' => '/^force_delete-firm-(?P<firm>\d+)-accounts$/',
            'description' => $makeDescriptionCallback('Finally delete any account in firm {firm}'),
        ],
    ],

    'keys' => \array_merge(
        \array_keys($plain),
        \array_keys($patterns),
    ),
];
