<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create([
            'name' => 'CSA',
        ]);

        Position::create([
            'name' => 'ESW',
        ]);

        Position::create([
            'name' => 'Scaffolder',
        ]);

        Position::create([
            'name' => 'Operator',
        ]);
    }
}
