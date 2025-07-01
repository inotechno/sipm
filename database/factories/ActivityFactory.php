<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Position;
use App\Models\Scope;
use App\Models\StatusActivity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' =>  fake()->date(),
            'title' => fake()->sentence(3),
            'slug' => fake()->slug(),
            'group_id' => Group::inRandomOrder()->first()->id,
            'position_id' => Position::inRandomOrder()->first()->id,
            'total_estimate' => fake()->randomFloat(0, 0, 100),
            'type_estimate' => fake()->randomElement(['hour', 'day', 'week', 'month', 'year']),
            'forecast_date' => fake()->date(),
            'plan_date' => fake()->date(),
            'actual_date' => fake()->date(),
            'supervisor_id' => User::inRandomOrder()->first()->id,
            'description' => fake()->text(100),
            'status_id' => StatusActivity::inRandomOrder()->first()->id
        ];
    }
}
