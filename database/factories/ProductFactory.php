<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Product::truncate();
        $productName = $this->faker->sentence(5);
        return [
            'name' => $productName,
            'slug' => Str::slug($productName),
            'description' => $this->faker->paragraph(5),
            'price' => mt_rand(10,100) / 10
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
