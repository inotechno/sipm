<?php

namespace App\Livewire\Component\Layout;

use App\Livewire\BaseComponent;
use Livewire\Component;

class Navbar extends BaseComponent
{
    public $menus = [];

    public function filterMenus()
    {
        $menus = [
            [
                'name' => 'Dashboard',
                'url' => '#',
                'route' => 'dashboard',
                'icon' => 'bx bx-grid-alt',
                'permissions' => ['dashboard.index'],
                'menus' => [
                    [
                        'name' => 'Dashboard Attendance',
                        'url' => route('dashboard'),
                        'route' => 'dashboard',
                        'icon' => 'bx bx-grid-alt',
                        'permissions' => ['dashboard.index']
                    ],
                    [
                        'name' => 'Dashboard Activity',
                        'url' => route('dashboard.activity'),
                        'route' => 'dahboard.activity',
                        'icon' => 'fas fa-tasks',
                        'permissions' => ['dashboard.index']
                    ],
                ]
            ],
            [
                'name' => 'Master Data',
                'icon' => 'bx bx-data',
                'permissions' => ['user.index', 'role.index', 'group.index', 'position.index', 'employee.index'],
                'url' => '#',
                'route' => '#',
                'menus' => [
                    [
                        'name' => 'User',
                        'url' => route('master.users'),
                        'route' => 'master.users',
                        'icon' => 'bx bx-user',
                        'permissions' => ['user.index', 'role.index'],
                        'menus' => [
                            [
                                'name' => 'User',
                                'url' => route('master.users'),
                                'route' => 'master.users',
                                'icon' => 'bx bx-user',
                                'permissions' => ['user.index', 'role.index'],
                            ],
                            [
                                'name' => 'Role',
                                'url' => route('master.roles'),
                                'route' => 'master.roles',
                                'icon' => 'bx bx-user',
                                'permissions' => ['role.index']
                            ],
                            [
                                'name' => 'Permission',
                                'url' => route('master.permissions'),
                                'route' => 'master.permissions',
                                'icon' => 'bx bx-user',
                                'permissions' => ['role.index']
                            ],
                        ]
                    ],
                    [
                        'name' => 'Employee',
                        'url' => route('master.employees'),
                        'route' => 'master.employees',
                        'icon' => 'bx bx-user',
                        'permissions' => ['employee.index', 'group.index', 'position.index'],
                        'menus' => [
                            [
                                'name' => 'Group',
                                'url' => route('master.groups'),
                                'route' => 'master.groups',
                                'icon' => 'bx bx-user',
                                'permissions' => ['group.index']
                            ],
                            [
                                'name' => 'Position',
                                'url' => route('master.positions'),
                                'route' => 'master.positions',
                                'icon' => 'bx bx-user-pin',
                                'permissions' => ['position.index']
                            ],
                            [
                                'name' => 'Employee',
                                'url' => route('master.employees'),
                                'route' => 'master.employees',
                                'icon' => 'bx bx-user',
                                'permissions' => ['employee.index']
                            ],
                        ]
                    ],
                    [
                        'name' => 'Activity',
                        'icon' => 'bx bx-report',
                        'permissions' => ['area.index', 'scope.index', 'category.dependency.index'],
                        'url' => '#',
                        'route' => '#',
                        'menus' => [
                            [
                                'name' => 'Area',
                                'url' => route('master.areas'),
                                'route' => 'master.areas',
                                'icon' => 'bx bx-map',
                                'permissions' => ['area.index']
                            ],
                            [
                                'name' => 'Scope',
                                'url' => route('master.scopes'),
                                'route' => 'master.scopes',
                                'icon' => 'bx bx-tag',
                                'permissions' => ['scope.index']
                            ],
                            [
                                'name' => 'Category Dependency',
                                'url' => route('master.category-dependencies'),
                                'route' => 'master.category-dependencies',
                                'icon' => 'bx bx-list-ol',
                                'permissions' => ['category.dependency.index']
                            ],
                        ]
                    ],
                    [
                        'name' => 'Shift',
                        'url' => route('master.shifts'),
                        'route' => 'master.shifts',
                        'icon' => 'bxs-tachometer',
                        'permissions' => ['shift.index']
                    ],
                ],
            ],
            [
                'name' => 'Attendance',
                'icon' => 'bx bx-time-five',
                'permissions' => ['attendance.index'],
                'url' => route('attendance'),
                'route' => 'attendance'
            ],
            [
                'name' => 'Activity',
                'icon' => 'bx bx-task',
                'permissions' => ['activity.index'],
                'url' => route('activity'),
                'route' => 'activity'
            ],
            [
                'name' => 'Daily Image',
                'icon' => 'bx bx-image-add',
                'permissions' => ['collection.image.index'],
                'url' => route('collection.images'),
                'route' => 'collection.images'
            ],
            [
                'name' => 'Monitoring',
                'icon' => 'bx bx-time-five',
                'permissions' => ['monitoring.present.index'],
                'url' => route('monitoring.present'),
                'route' => 'monitoring.present'
            ],
            [
                'name' => 'Announcement',
                'icon' => 'bx bx-bell',
                'permissions' => ['announcement.index'],
                'url' => route('announcement'),
                'route' => 'announcement'
            ],
            [
                'name' => 'Report',
                'icon' => 'bx bxs-report',
                'permissions' => ['activity.report.index'],
                'url' => '#',
                'route' => '#',
                'menus' => [
                    [
                        'name' => 'Activity',
                        'icon' => 'bx bx-report',
                        'permissions' => ['activity.report.index'],
                        'url' => '#',
                        'route' => '#',
                        'menus' => [
                            [
                                'name' => 'Report Activity',
                                'icon' => 'bx bx-report',
                                'permissions' => ['activity.report.index'],
                                'url' => route('activity.report'),
                                'route' => 'activity.report',
                            ],
                            [
                                'name' => 'Report Activity Progress',
                                'icon' => 'bx bx-report',
                                'permissions' => ['activity.report.index'],
                                'url' => route('activity.report.progress'),
                                'route' => 'activity.report.progress'
                            ],
                        ]
                    ],
                    [
                        'name' => 'Attendance',
                        'icon' => 'bx bx-report',
                        'permissions' => ['attendance.report.index'],
                        'url' => '#',
                        'route' => '#',
                        'menus' => [
                            [
                                'name' => 'Report Attendance',
                                'icon' => 'bx bx-report',
                                'permissions' => ['attendance.report.index'],
                                'url' => route('attendance.report'),
                                'route' => 'attendance.report.index'
                            ],
                        ]
                    ]
                ],
            ],
            [
                'name' => 'File Manager',
                'icon' => 'bx bx-folder',
                'permissions' => ['file.index'],
                'url' => route('files'),
                'route' => 'files'
            ],
        ];

        $this->menus = array_filter($menus, function ($menu) {
            return $this->authUser->hasAnyPermission($menu['permissions']);
        });

        foreach ($this->menus as &$menu) {
            if (isset($menu['menus'])) {
                $menu['menus'] = array_filter($menu['menus'], function ($subMenu) {
                    return $this->authUser->hasAnyPermission($subMenu['permissions']);
                });

                foreach ($menu['menus'] as &$subMenu) {
                    if (isset($subMenu['menus'])) {
                        $subMenu['menus'] = array_filter($subMenu['menus'], function ($subSubMenu) {
                            return $this->authUser->hasAnyPermission($subSubMenu['permissions']);
                        });
                    }
                }
            }
        }
    }

    public function mount()
    {
        $this->filterMenus();
    }

    public function render()
    {
        return view('livewire.component.layout.navbar');
    }
}
