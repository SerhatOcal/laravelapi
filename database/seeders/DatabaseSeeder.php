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
        \App\Models\User::factory(100)->create();
        \App\Models\Product::factory(500)->create();
        \App\Models\Category::factory(30)->create();
        $this->call(ProductCategories::class);
    }
}
