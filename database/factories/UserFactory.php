<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Services\UserPasswordEncoder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use function now;
use function resolve;

/**
 * @method self hasIntegrations($countOrStateOrCallback = 1, $stateOrCallback = [])
 * @method self hasClients($countOrStateOrCallback = 1, $stateOrCallback = [])
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => $this->faker->randomElement([null, now()]),
            'password' => resolve(UserPasswordEncoder::class)->encode('password'),
            'remember_token' => $this->faker->randomElement([null, Str::random(10)]),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
