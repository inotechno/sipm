<?php

namespace Database\Seeders;

use App\Models\Scope;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Scope::create([
            'name' => 'Installation of Cable Containment',
        ]);

        Scope::create([
            'name' => 'Pulling & Termination LV & Earthing Cable',
        ]);

        Scope::create([
            'name' => 'Installation Lighting & Power Receptacle',
        ]);

        Scope::create([
            'name' => 'Wall Opening to Corridor',
        ]);
    }
}
