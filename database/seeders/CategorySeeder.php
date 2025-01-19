<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// create demo data
// php artisan db:seed --class=CategorySeeder
class CategorySeeder extends Seeder
{

    public function run(): void
    {
        $cateogries = ['work', 'personal', 'projects', 'education'];

        foreach ($cateogries as $category) {
            Category::create(['name' => $category]);
        }
    }
}
