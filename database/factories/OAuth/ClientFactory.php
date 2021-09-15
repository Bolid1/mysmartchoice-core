<?php

declare(strict_types=1);

namespace Database\Factories\OAuth;

use App\Models\OAuth\Client;
use Laravel\Passport\Database\Factories\ClientFactory as PassportFactory;

class ClientFactory extends PassportFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;
}
