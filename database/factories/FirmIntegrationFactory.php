<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\FirmIntegration;
use Illuminate\Database\Eloquent\Factories\Factory;

class FirmIntegrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FirmIntegration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }
}
