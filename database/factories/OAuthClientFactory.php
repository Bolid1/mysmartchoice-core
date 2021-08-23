<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\OAuthClient;
use Laravel\Passport\Database\Factories\ClientFactory;

class OAuthClientFactory extends ClientFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OAuthClient::class;
}
