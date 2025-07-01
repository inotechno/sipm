<?php

namespace Database\Seeders;

use App\Models\CategoryDependency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryDependencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryDependency::create([
            'name' => 'Perubahan Gambar',
            'slug' => 'perubahan-gambar',
        ]);

        CategoryDependency::create([
            'name' => 'Clash With Busduct',
            'slug' => 'clash-with-busduct',
        ]);
    }
}
