<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Technology',
            'Programming',
            'Web Development',
            'Mobile Development',
            'DevOps',
            'Data Science',
            'Artificial Intelligence',
            'Cybersecurity',
            'Cloud Computing',
            'Design',
            'Business',
            'Productivity',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category)],
                ['name' => $category]
            );
        }
    }
}
