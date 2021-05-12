<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Category::truncate();
        $categoryName = rtrim($this->faker->sentence(1), '.');
        return [
            'name' => $categoryName,
            'slug' => Str::slug($categoryName)
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
