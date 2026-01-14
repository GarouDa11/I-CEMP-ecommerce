<?php
// File: database/seeders/ProductSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Committee;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $entrepreneurshipClub = Committee::where('club_name', 'Entrepreneurship Club')->first();
        $swimmingClub = Committee::where('club_name', 'Swimming Club')->first();

        // Product 1: Taekwondo Pin
        $product1 = Product::create([
            'name' => 'Taekwondo Design Buttons Pin',
            'description' => 'High-quality metal pin with Taekwondo design. Perfect for martial arts enthusiasts and collectors.',
            'price' => 5.00,
            'original_price' => null,
            'stock' => 50,
            'sold_count' => 12,
            'material' => 'Metal Stainless Steel',
            'size' => '3cm diameter',
            'weight' => '10g',
            'category' => 'merch',
            'committee_id' => $entrepreneurshipClub->id,
            'main_image' => 'images/product/Taekwondo-pin.jpg',
            'is_active' => true,
        ]);

        ProductImage::create([
            'product_id' => $product1->id,
            'image_path' => 'images/product/Taekwondo-pin.jpg',
            'order' => 1,
        ]);

        // Product 2: Kamen Rider Belt
        $product2 = Product::create([
            'name' => 'Kamen Rider Faiz Belt Full Set',
            'description' => 'Complete transformation belt set from Kamen Rider Faiz series. Includes sound effects and LED lights.',
            'price' => 20.50,
            'original_price' => 25.00,
            'stock' => 15,
            'sold_count' => 8,
            'material' => 'ABS Plastic',
            'size' => 'Adjustable waist belt',
            'weight' => '500g',
            'category' => 'merch',
            'committee_id' => $entrepreneurshipClub->id,
            'main_image' => 'images/product/kamenrider-faiz-belt.jpg',
            'is_active' => true,
        ]);

        ProductImage::create([
            'product_id' => $product2->id,
            'image_path' => 'images/product/kamenrider-faiz-belt.jpg',
            'order' => 1,
        ]);

        // Product 3: Swimming Goggles (placeholder until you find image)
        $product3 = Product::create([
            'name' => 'Professional Swimming Goggles',
            'description' => 'Anti-fog swimming goggles with UV protection. Comfortable silicone strap and adjustable nose bridge.',
            'price' => 15.00,
            'original_price' => 18.00,
            'stock' => 30,
            'sold_count' => 25,
            'material' => 'Silicone & Polycarbonate Lens',
            'size' => 'One size fits all',
            'weight' => '80g',
            'category' => 'tech',
            'committee_id' => $swimmingClub->id,
            'main_image' => 'https://images.unsplash.com/photo-1519315901367-f34ff9154487?w=600&h=600&fit=crop',
            'is_active' => true,
        ]);

        ProductImage::create([
            'product_id' => $product3->id,
            'image_path' => 'https://images.unsplash.com/photo-1519315901367-f34ff9154487?w=600&h=600&fit=crop',
            'order' => 1,
        ]);

        // Product 4: Swimming Cap (placeholder until you find image)
        $product4 = Product::create([
            'name' => 'Silicone Swimming Cap',
            'description' => 'Durable silicone swimming cap. Waterproof and comfortable fit.',
            'price' => 8.00,
            'original_price' => null,
            'stock' => 40,
            'sold_count' => 18,
            'material' => '100% Silicone',
            'size' => 'Standard',
            'weight' => '50g',
            'category' => 'merch',
            'committee_id' => $swimmingClub->id,
            'main_image' => 'https://images.unsplash.com/photo-1530549387789-4c1017266635?w=600&h=600&fit=crop',
            'is_active' => true,
        ]);

        ProductImage::create([
            'product_id' => $product4->id,
            'image_path' => 'https://images.unsplash.com/photo-1530549387789-4c1017266635?w=600&h=600&fit=crop',
            'order' => 1,
        ]);

        // Product 5: Cultural Week T-Shirt (placeholder until you find image)
        $product5 = Product::create([
            'name' => 'Cultural Week Special Edition T-Shirt',
            'description' => 'Limited edition t-shirt celebrating cultural diversity. Comfortable cotton blend.',
            'price' => 12.00,
            'original_price' => 15.00,
            'stock' => 25,
            'sold_count' => 35,
            'material' => '100% Cotton',
            'size' => 'S, M, L, XL',
            'weight' => '200g',
            'category' => 'clothing',
            'committee_id' => $entrepreneurshipClub->id,
            'main_image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&h=600&fit=crop',
            'is_active' => true,
        ]);

        ProductImage::create([
            'product_id' => $product5->id,
            'image_path' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&h=600&fit=crop',
            'order' => 1,
        ]);

        // Product 6: Business Notebook (placeholder until you find image)
        $product6 = Product::create([
            'name' => 'Premium Business Notebook',
            'description' => 'High-quality leather notebook for entrepreneurs. 200 pages of premium paper.',
            'price' => 18.00,
            'original_price' => 22.00,
            'stock' => 20,
            'sold_count' => 15,
            'material' => 'Leather Cover, Premium Paper',
            'size' => 'A5',
            'weight' => '300g',
            'category' => 'merch',
            'committee_id' => $entrepreneurshipClub->id,
            'main_image' => 'https://images.unsplash.com/photo-1517842645767-c639042777db?w=600&h=600&fit=crop',
            'is_active' => true,
        ]);

        ProductImage::create([
            'product_id' => $product6->id,
            'image_path' => 'https://images.unsplash.com/photo-1517842645767-c639042777db?w=600&h=600&fit=crop',
            'order' => 1,
        ]);
    }
}