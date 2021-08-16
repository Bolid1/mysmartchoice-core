<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Integration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IntegrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Integration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'owner_id' => $this->faker->randomElement(User::all()->pluck('id')->all()),
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement([
                Integration::STATUS_DRAFT,
                Integration::STATUS_AVAILABLE,
            ]),
        ];
    }
}
