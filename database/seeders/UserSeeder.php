<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@kms',
            'password' => bcrypt('password'),
        ]);

        $superadmin->assignRole('Super Admin');

        $site_manager = User::create([
            'name' => 'Site Manager',
            'email' => 'site_manager@kms',
            'password' => bcrypt('password'),
        ]);

        $site_manager->assignRole('Site Manager');

        $project_manager = User::create([
            'name' => 'Project Director',
            'email' => 'project_director@kms',
            'password' => bcrypt('password'),
        ]);

        $project_manager->assignRole('Project Director');

        $project_manager = User::create([
            'name' => 'Project Manager',
            'email' => 'project_manager@kms',
            'password' => bcrypt('password'),
        ]);

        $project_manager->assignRole('Project Manager');

        $quality_control = User::create([
            'name' => 'Quality Control',
            'email' => 'quality_control@kms',
            'password' => bcrypt('password'),
        ]);

        $quality_control->assignRole('Quality Control');

        $quality_control = User::create([
            'name' => 'HSE',
            'email' => 'hse@kms',
            'password' => bcrypt('password'),
        ]);

        $quality_control->assignRole('HSE');

        $supervisor = [
            'Ahmad Yani',
            'Ari Hartonko',
            'Madroni',
            'Muhammad Ammar Fadhlurrohman',
            'Ade Muhammad',
            'Novetus Fabiola K',
            'Johani',
            'Jaya Zaelani',
            'Nanang Setiawan',
            'Farhan Abdurrahmat',
            'Hikmatuallah','Septiandri',
            'Dede Andri Irawan',
            'Kardita',
        ];
        
        foreach ($supervisor as $supervisor) {
            $user = User::create([
                'name' => strtoupper($supervisor),
                'email' => str_replace(' ', '', strtolower($supervisor)) . '@kms',
                'password' => bcrypt('password'),
            ]);

            $user->assignRole('Supervisor');
        }
    }
}
