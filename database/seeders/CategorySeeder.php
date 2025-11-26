<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'color' => 'blue',
        ]);
        Category::create([
            'name' => 'Web Design',
            'slug' => 'web-design',
            'color' => 'cyan',
        ]);
        Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'color' => 'green',
        ]);
        Category::create([
            'name' => 'Mobile Development',
            'slug' => 'mobile-development',
            'color' => 'red',
        ]);
        Category::create([
            'name' => 'UI/UX Design',
            'slug' => 'ui-ux-design',
            'color' => 'yellow',
        ]);
        Category::create([
            'name' => 'Game Development',
            'slug' => 'game-development',
            'color' => 'lime',
        ]);
        Category::create([
            'name' => 'Artificial Intelligence',
            'slug' => 'artificial-intelligence',
            'color' => 'purple',
        ]);
        Category::create([
            'name' => 'Data Science',
            'slug' => 'data-science',
            'color' => 'stone',
        ]);
    }
}
