<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public function run()
    {
        Category::query()->create([
            'name' => 'Work'
        ]);
        Category::query()->create([
            'name' => 'Personal'
        ]);
        Category::query()->create([
            'name' => 'Home'
        ]);
        Category::query()->create([
            'name' => 'Health'
        ]);
        Category::query()->create([
            'name' => 'Social'
        ]);
    }
}
