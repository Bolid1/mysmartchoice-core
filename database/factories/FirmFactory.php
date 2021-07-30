<?php

namespace Database\Factories;

use App\Models\Firm;
use App\Services\UserPasswordEncoder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use function now;
use function resolve;

class FirmFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Firm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->company(),
        ];
    }
}
