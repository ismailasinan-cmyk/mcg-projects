<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'action' => $this->faker->randomElement(['create', 'update', 'delete', 'login']),
            'subject_type' => 'App\Models\Project',
            'subject_id' => $this->faker->randomNumber(),
            'description' => $this->faker->sentence(),
            'ip_address' => $this->faker->ipv4(),
            'changes' => null,
        ];
    }
}
