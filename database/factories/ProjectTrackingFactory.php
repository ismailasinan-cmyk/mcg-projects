<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectTracking>
 */
class ProjectTrackingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'company' => $this->faker->company(),
            'client' => $this->faker->name(),
            'project' => $this->faker->sentence(3),
            'country' => 'Nigeria',
            'state' => 'Lagos',
            'lga' => 'Ikeja',
            'cost' => $this->faker->randomFloat(2, 1000, 1000000),
            'activity' => $this->faker->sentence(),
            'progress' => '20%',
            'responsible' => $this->faker->name(),
            'status' => $this->faker->randomElement(['moving_forward', 'in_progress', 'no_progress']),
        ];
    }
}
