<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class TestSeeder extends Seeder
{
    public function run()
    {
        $category = Category::firstOrCreate(
            ['slug' => 'roti-manis'],
            [
                'name' => 'Roti Manis'
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'almond-croissant'],
            [
                'category_id' => $category->id,
                'name' => 'Almond Croissant',
                'description' => 'Croissant renyah ganda dengan isian krim almond (frangipane) yang manis dan taburan irisan almond di atasnya.',
                'price' => 38000,
                'image' => null,
                'rating' => 4.9,
                'is_active' => true,
                'stock' => 50,
            ]
        );
    }
}
