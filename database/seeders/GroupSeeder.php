<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name' => 'RMU & Support Sasuso',
                'slug' => 'rmu-support-sasuso',
                'supervisor_id' => 7,
                'shift_id' => 1
            ],
            [
                'name' => 'Mecanical Gantry',
                'slug' => 'mechanical-gantry',
                'supervisor_id' => 8,
                'shift_id' => 1
            ],
            [
                'name' => 'IT Room',
                'slug' => 'it-room',
                'supervisor_id' => 9,
                'shift_id' => 1
            ],
            [
                'name'=> 'Coridor',
                'slug' => 'coridor',
                'supervisor_id' => 10,
                'shift_id' => 1
            ],
            [
                'name'=> 'Data Hall',
                'slug' => 'data-hall',
                'supervisor_id' => 11,
                'shift_id' => 1
            ],
            [
                'name'=> 'IT Room',
                'slug' => 'it-room',
                'supervisor_id' => 12,
                'shift_id' => 1
            ],
            [
                'name' => 'Workhsop & Langsir',
                'slug' => 'workshop-langsir',
                'supervisor_id' => 13,
                'shift_id' => 1
            ],
            [
                'name'=> 'Coridor',
                'slug' => 'coridor',
                'supervisor_id' => 14,
                'shift_id' => 2
            ],
            [
                'name'=> 'Data Hall',
                'slug' => 'data-hall',
                'supervisor_id' => 15,
                'shift_id' => 2
            ],
            [
                'name'=> 'Data Hall',
                'slug' => 'data-hall',
                'supervisor_id' => 16,
                'shift_id' => 2
            ],
            [
                'name'=> 'IT Room',
                'slug' => 'it-room',
                'supervisor_id' => 17,
                'shift_id' => 2
            ],
            [
                'name' => 'Mecanical Gantry',
                'slug' => 'mechanical-gantry',
                'supervisor_id' => 18,
                'shift_id' => 2
            ],
            [
                'name'=> 'IT Room',
                'slug' => 'it-room',
                'supervisor_id' => 19,
                'shift_id' => 2
            ],
            [
                'name' => 'Workhsop',
                'slug' => 'workshop',
                'supervisor_id' => 20,
                'shift_id' => 2
            ],
        ];

        foreach ($groups as $group) {
            Group::create($group);
        }
    }
}
