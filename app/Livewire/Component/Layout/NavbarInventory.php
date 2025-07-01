<?php

namespace App\Livewire\Component\Layout;

use App\Livewire\BaseComponent;
use Livewire\Component;

class NavbarInventory extends BaseComponent
{
    public $menus = [];

    public function filterMenus()
    {
        $menus = [
            [
                'name' => 'Dashboard',
                'url' => route('inventory.dashboard'),
                'route' => 'inventory.dashboard',
                'icon' => 'bx bx-grid-alt',
                'permissions' => ['inventory.dashboard']
            ],
            [
                'name' => 'Master Data',
                'icon' => 'bx bx-data',
                'permissions' => ['inventory.index', 'category.inventory.index'],
                'url' => '#',
                'route' => '#',
                'menus' => [
                    [
                        'name' => 'Warehouse',
                        'url' => route('inventory.warehouse'),
                        'route' => 'inventory.warehouse',
                        'icon' => 'bx bx-building',
                        'permissions' => ['warehouse.index']
                    ],
                    [
                        'name' => 'Category Inventory',
                        'url' => route('inventory.category'),
                        'route' => 'inventory.category',
                        'icon' => 'bx bx-category',
                        'permissions' => ['category.inventory.index']
                    ],
                    [
                        'name' => 'Inventory',
                        'url' => route('inventory.inventory'),
                        'route' => 'inventory.inventory',
                        'icon' => 'bx bx-package',
                        'permissions' => ['inventory.index'],
                    ],
                ],
            ],
            [
                'name' => 'Peminjaman',
                'icon' => 'bx bx-export',
                'permissions' => ['outbound.index'],
                'url' => route('inventory.outbound'),
                'route' => 'inventory.outbound',
            ],
            [
                'name' => 'Pengembalian',
                'icon' => 'bx bx-import',
                'permissions' => ['inbound.index'],
                'url' => route('inventory.inbound'),
                'route' => 'inventory.inbound',
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
        return view('livewire.component.layout.navbar-inventory');
    }
}
