<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('status_activities')->insert([
            [
                'id' => 1,
                'name' => 'Active',
                'description' => 'The activity is active',
                'bg_color' => 'bg-success',
                'text_color' => 'text-white',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Inactive',
                'description' => 'The activity is inactive',
                'bg_color' => 'bg-danger',
                'text_color' => 'text-white',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Pending',
                'description' => 'The activity is pending',
                'bg_color' => 'bg-warning',
                'text_color' => 'text-white',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
