<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class BreadProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori Sourdough
        $sourdough = Category::firstOrCreate(
            ['slug' => 'sourdough'],
            ['name' => 'Sourdough']
        );
        
        // 2. Kategori Pastry & Viennoiserie
        $pastry = Category::firstOrCreate(
            ['slug' => 'pastry-viennoiserie'],
            ['name' => 'Pastry & Viennoiserie']
        );
        
        // 3. Kategori Roti Manis & Gurih
        $sweetSavory = Category::firstOrCreate(
            ['slug' => 'roti-klasik'],
            ['name' => 'Roti Klasik']
        );

        // 4. Kategori Minuman (Beverages)
        $beverage = Category::firstOrCreate(
            ['slug' => 'kopi-minuman'],
            ['name' => 'Kopi & Minuman']
        );

        $products = [
            // SOURDOUGH
            [
                'name' => 'Classic Sourdough Loaf',
                'description' => 'Sourdough klasik dengan kerak renyah dan bagian dalam yang kenyal. Fermentasi 48 jam dengan rasa asam yang pas.',
                'price' => 45000,
                'rating' => 4.9,
                'category_id' => $sourdough->id
            ],
            [
                'name' => 'Rustic Baguette',
                'description' => 'Baguette gaya Prancis otentik dengan kerak tipis dan renyah. Sempurna untuk dinikmati dengan mentega.',
                'price' => 35000,
                'rating' => 4.8,
                'category_id' => $sourdough->id
            ],
            [
                'name' => 'Whole Wheat Walnut Sourdough',
                'description' => 'Roti gandum utuh sourdough dengan tambahan kacang walnut panggang, kaya serat alami.',
                'price' => 55000,
                'rating' => 4.7,
                'category_id' => $sourdough->id
            ],

            // PASTRY & VIENNOISERIE
            [
                'name' => 'French Butter Croissant',
                'description' => 'Croissant berlapis yang sangat flaky dan buttery, menggunakan mentega asli Prancis.',
                'price' => 28000,
                'rating' => 5.0,
                'category_id' => $pastry->id
            ],
            [
                'name' => 'Pain au Chocolat',
                'description' => 'Pastry berlapis mentega dengan isian dua bar cokelat hitam Valrhona berkualitas tinggi.',
                'price' => 32000,
                'rating' => 4.9,
                'category_id' => $pastry->id
            ],
            [
                'name' => 'Almond Croissant',
                'description' => 'Croissant dua kali panggang yang diisi dengan krim almond lembut.',
                'price' => 35000,
                'rating' => 4.8,
                'category_id' => $pastry->id
            ],

            // ROTI KLASIK (SWEET & SAVORY)
            [
                'name' => 'Hokkaido Milk Bread',
                'description' => 'Roti tawar Jepang yang sangat empuk, berserat halus, dan milky.',
                'price' => 40000,
                'rating' => 4.9,
                'category_id' => $sweetSavory->id
            ],
            [
                'name' => 'Chocolate Babka',
                'description' => 'Roti kepang manis khas Eropa dengan pusaran cokelat pekat.',
                'price' => 60000,
                'rating' => 4.9,
                'category_id' => $sweetSavory->id
            ],
            [
                'name' => 'Olive & Rosemary Focaccia',
                'description' => 'Focaccia klasik Italia dengan minyak zaitun extra virgin dan rosemary segar.',
                'price' => 40000,
                'rating' => 4.8,
                'category_id' => $sweetSavory->id
            ],
            [
                'name' => 'Smoked Beef Croissant',
                'description' => 'Croissant gurih dengan isian irisan daging asap dan lelehan keju.',
                'price' => 38000,
                'rating' => 4.8,
                'category_id' => $sweetSavory->id
            ],
            
            // KOPI & MINUMAN
            [
                'name' => 'Iced Artisan Latte',
                'description' => 'Es Kopi Susu perpaduan espresso Arabica dengan susu segar yang creamy.',
                'price' => 28000,
                'rating' => 4.8,
                'category_id' => $beverage->id
            ],
            [
                'name' => 'Hot Americano',
                'description' => 'Espresso house blend yang diseduh dengan air panas, memberikan rasa kopi yang bersih.',
                'price' => 22000,
                'rating' => 4.7,
                'category_id' => $beverage->id
            ],
            [
                'name' => 'Matcha Latte',
                'description' => 'Serbuk teh hijau premium Uji Matcha dipadukan dengan susu segar manis yang lembut.',
                'price' => 32000,
                'rating' => 4.9,
                'category_id' => $beverage->id
            ]
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['slug' => Str::slug($product['name'])],
                [
                    'category_id' => $product['category_id'],
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'rating' => $product['rating'],
                    'is_active' => true,
                    'stock' => 20, // default stock
                ]
            );
        }
    }
}
