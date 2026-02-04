<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'state' => $this->faker->randomElement(['Lagos', 'Kano', 'Rivers', 'Abia', 'FCT']),
            'status' => $this->faker->randomElement(['ongoing', 'completed', 'suspended', 'operation', 'pending', 'planned']),
            'description' => $this->faker->paragraph,
        ];
    }
}
