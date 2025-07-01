<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Scope;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityDetail>
 */
class ActivityDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'activity_id' => Activity::inRandomOrder()->first()->id,
            'scope_id' => Scope::inRandomOrder()->first()->id,
        ];
    }
}
