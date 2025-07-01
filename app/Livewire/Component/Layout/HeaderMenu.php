<?php

namespace App\Livewire\Component\Layout;

use App\Livewire\BaseComponent;
use Livewire\Component;

class HeaderMenu extends BaseComponent
{
    public $menus = [];
    public $activePrevixMenu = null;

    public function filterMenus()
    {
        $menus = [
            [
                'name' => 'Inventory',
                'icon' => 'bx bx-package',
                'permissions' => ['inventory.dashboard'],
                'url' => route('inventory.dashboard'),
                'route' => 'inventory.dashboard',
                'prefix' => '/inventory',
            ],
            [
                'name' => 'Activity & Attendance',
                'icon' => 'bx bx-time-five',
                'permissions' => ['dashboard.index'],
                'url' => route('dashboard'),
                'route' => 'dashboard',
                'prefix' => '',
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
        $this->activePrevixMenu = request()->route()->getPrefix();
        $this->filterMenus();
    }

    public function render()
    {
        return view('livewire.component.layout.header-menu');
    }
}
