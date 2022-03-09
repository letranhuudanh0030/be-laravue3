<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Sale::factory(50)->create();
        // \App\Models\User::factory(10)->create();
        // \App\Models\Category::factory(15)->create();
        // for ($i = 16; $i < 21; $i++) {
        //     \App\Models\Category::where('parent_id', $i)->get()->each(function (\App\Models\Category $category) {

                // \App\Models\Article::factory()->count(5)->create([
                //     'category_id' => $category->id,
                // ]);

        //         \App\Models\Category::factory()->count(2)->create([
        //             'parent_id' => $category->id,
        //         ]);
        //     });
        // }
    }
}
