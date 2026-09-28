<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ArtisanProductSeeder extends Seeder
{
    public function run(): void
    {
        // Temukan atau buat kategori Artisan/Sourdough
        $category = Category::firstOrCreate(
            ['slug' => 'artisan-bread'],
            ['name' => 'Artisan Bread']
        );

        $products = [
            [
                'name' => 'Classic Country Sourdough',
                'description' => 'Sourdough klasik dengan kerak renyah dan bagian dalam yang kenyal. Fermentasi 48 jam dengan rasa asam yang pas.',
                'price' => 45000,
                'rating' => 4.9,
            ],
            [
                'name' => 'Rustic Baguette',
                'description' => 'Baguette gaya Prancis otentik dengan kerak tipis dan renyah. Sempurna untuk sandwich atau dinikmati dengan mentega.',
                'price' => 35000,
                'rating' => 4.8,
            ],
            [
                'name' => 'Whole Wheat Walnut Sourdough',
                'description' => 'Roti gandum utuh sourdough dengan tambahan kacang walnut panggang, kaya serat dan rasa manis alami.',
                'price' => 55000,
                'rating' => 4.7,
            ],
            [
                'name' => 'Olive & Rosemary Focaccia',
                'description' => 'Focaccia klasik Italia yang dipanggang dengan minyak zaitun extra virgin, zaitun hitam, dan rosemary segar.',
                'price' => 40000,
                'rating' => 4.9,
            ],
            [
                'name' => 'Multigrain Seeded Loaf',
                'description' => 'Roti sehat padat nutrisi dengan campuran biji rami, biji bunga matahari, oat, dan wijen hitam.',
                'price' => 50000,
                'rating' => 4.6,
            ],
            [
                'name' => 'French Butter Croissant',
                'description' => 'Croissant berlapis yang sangat flaky dan buttery, menggunakan mentega asli Prancis (Elle & Vire).',
                'price' => 28000,
                'rating' => 5.0,
            ],
            [
                'name' => 'Pain au Chocolat',
                'description' => 'Pastry berlapis mentega dengan isian dua bar cokelat hitam Valrhona berkualitas tinggi di dalamnya.',
                'price' => 32000,
                'rating' => 4.9,
            ],
            [
                'name' => 'Jalapeño & Cheddar Sourdough',
                'description' => 'Sourdough gurih dengan potongan cabai jalapeño dan keju cheddar matang yang meleleh sempurna di dalam.',
                'price' => 60000,
                'rating' => 4.8,
            ],
            [
                'name' => 'Rye Bread (Pumpernickel)',
                'description' => 'Roti gandum hitam (rye) ala Jerman yang padat, agak manis, dan berwarna gelap. Sangat cocok dengan irisan daging.',
                'price' => 55000,
                'rating' => 4.7,
            ],
            [
                'name' => 'Cranberry Pecan Boule',
                'description' => 'Boule sourdough bulat dengan buah cranberry kering yang manis-asam dan kacang pecan renyah.',
                'price' => 65000,
                'rating' => 4.8,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['slug' => Str::slug($product['name'])],
                [
                    'category_id' => $category->id,
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'rating' => $product['rating'],
                    'is_active' => true,
                    'stock' => 20, // default stock if needed
                ]
            );
        }
    }
}
