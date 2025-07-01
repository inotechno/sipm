<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RoleSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(ShiftSeeder::class);

        $this->call(GroupSeeder::class);

        $this->call(PositionSeeder::class);

        $this->call(ScopeSeeder::class);

        $this->call(CategoryDependencySeeder::class);

        $this->call(StatusActivitySeeder::class);
        // $this->call(ActivitySeeder::class);
        // $this->call(ActivityDetailSeeder::class);

        $this->call(EmployeeSeeder::class);
        // $this->call(AttendanceConfigSeeder::class);

        // $this->call(ShiftScheduleSeeder::class);

        // $this->call(AttendanceSeeder::class);
    }
}
