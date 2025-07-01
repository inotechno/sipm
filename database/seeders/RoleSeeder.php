<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Site Manager']);
        Role::create(['name' => 'Supervisor']);
        Role::create(['name' => 'Project Manager']);
        Role::create(['name' => 'Quality Control']);
        Role::create(['name' => 'Project Director']);
        Role::create(['name' => 'HSE']);

        $permissions = [
            // Dashboard
            'dashboard.index' => [
                'Super Admin',
                'Site Manager',
                // 'Supervisor',
                'Project Manager',
                'Quality Control',
                'Project Director',
            ],

            // Manage User & Role
            'user.index' => [
                'Super Admin',
            ],
            'user.create' => [
                'Super Admin',
            ],
            'user.edit' => [
                'Super Admin',
            ],
            'user.destroy' => [
                'Super Admin',
            ],
            'role.index' => [
                'Super Admin',
            ],
            'role.create' => [
                'Super Admin',
            ],
            'role.edit' => [
                'Super Admin',
            ],
            'role.destroy' => [
                'Super Admin',
            ],

            // Manage Category Dependency
            'category.dependency.index' => [
                'Super Admin',
                'Site Manager',
            ],
            'category.dependency.create' => [
                'Super Admin',
                'Site Manager',
            ],
            'category.dependency.edit' => [
                'Super Admin',
                'Site Manager',
            ],
            'category.dependency.destroy' => [
                'Super Admin',
                'Site Manager',
            ],

            // Manage Group
            'group.index' => [
                'Super Admin',
                'Site Manager',
                'Supervisor',
            ],
            'group.create' => [
                'Super Admin',
                'Site Manager',
            ],
            'group.edit' => [
                'Super Admin',
                'Site Manager',
            ],
            'group.destroy' => [
                'Super Admin',
                'Site Manager',
            ],

            // Manage Position
            'position.index' => [
                'Super Admin',
                'Site Manager',
            ],
            'position.create' => [
                'Super Admin',
                'Site Manager',
            ],
            'position.edit' => [
                'Super Admin',
                'Site Manager',
            ],
            'position.destroy' => [
                'Super Admin',
                'Site Manager',
            ],

            // Manage Employee
            'employee.index' => [
                'Super Admin',
                'Site Manager',
                'Supervisor',
            ],
            'employee.create' => [
                'Super Admin',
                'Site Manager',
            ],
            'employee.edit' => [
                'Super Admin',
                'Site Manager',
            ],
            'employee.destroy' => [
                'Super Admin',
                'Site Manager',
            ],

            // Manage Scope
            'scope.index' => [
                'Super Admin',
                'Project Manager',
                'Site Manager',
            ],
            'scope.create' => [
                'Super Admin',
                'Project Manager',
                'Site Manager',
            ],
            'scope.edit' => [
                'Super Admin',
                'Project Manager',
            ],
            'scope.destroy' => [
                'Super Admin',
                'Project Manager',
            ],

            // Manage Shift
            'shift.index' => [
                'Super Admin',
                'Project Manager',
                'Site Manager',
                'Supervisor',
            ],
            'shift.create' => [
                'Super Admin',
                'Project Manager',
            ],
            'shift.edit' => [
                'Super Admin',
                'Project Manager',
            ],
            'shift.destroy' => [
                'Super Admin',
                'Project Manager',
            ],

            // Attendance
            'attendance.index' => [
                'Super Admin',
                'Site Manager',
                'Supervisor',
                'HSE'
            ],

            // Manage Activity
            'activity.index' => [
                'Super Admin',
                'Site Manager',
                'Supervisor',
                'Quality Control',
                'HSE'
            ],
            'activity.create' => [
                'Super Admin',
                'Site Manager',
            ],
            'activity.edit' => [
                'Super Admin',
                'Site Manager',
            ],
            'activity.destroy' => [
                'Super Admin',
                'Site Manager',
            ],

            // Manage Activity
            'monitoring.present.index' => [
                'Super Admin',
                'Site Manager',
                'Supervisor',
                'HSE'
            ],
            'monitoring.present.create' => [
                'Super Admin',
                'Supervisor',
                'HSE'
            ],
            'monitoring.present.edit' => [
                'Super Admin',
                'Site Manager',
                'HSE',
                'Supervisor',
            ],
            'monitoring.present.destroy' => [
                'Super Admin',
                'Site Manager',
            ],

            // Update Progress Activity
            'activity.progress.update' => [
                'Super Admin',
                'Supervisor',
                'Site Manager',
            ],

            // Update Validation Activity
            'activity.validation.update' => [
                'Super Admin',
                'HSE',
            ],

            // Update Issue Activity
            'activity.issue.update' => [
                'Super Admin',
                'Supervisor',
                'Site Manager',
            ],

            // Manage Dependency Activity
            'activity.dependency.index' => [
                'Super Admin',
                'Supervisor',
                'Site Manager',
            ],
            'activity.dependency.create' => [
                'Super Admin',
                'Supervisor',
                'Site Manager',
            ],
            'activity.dependency.edit' => [
                'Super Admin',
                'Supervisor',
                'Site Manager',
            ],
            'activity.dependency.destroy' => [
                'Super Admin',
                'Supervisor',
                'Site Manager',
            ],

            // View Report Activity
            'activity.report.index' => [
                'Super Admin',
                'Project Director',
            ],

            // View Report Attendance
            'attendance.report.index' => [
                'Super Admin',
                'Project Director',
            ],

            // View Dashboard Summary
            'dashboard.summary.index' => [
                'Super Admin',
                'Project Director',
            ],
        ];

        foreach ($permissions as $permissionName => $roles) {
            $permission = Permission::create([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);

            // Assign permission to roles
            foreach ($roles as $roleName) {
                $role = Role::firstOrCreate(['name' => $roleName]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
