<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::create([
            'name' => 'Koperty',
            'detail' => 'koperty'
        ]);

        $product = Product::create([
            'name' => 'Kartony',
            'detail' => 'kartony'
        ]);

        $product = Product::create([
            'name' => 'Kangurki',
            'detail' => 'kangurki'
        ]);

        $product = Product::create([
            'name' => 'Naklejki',
            'detail' => 'naklejki'
        ]);

        $product = Product::create([
            'name' => 'Etykiety',
            'detail' => 'etykiety'
        ]);
    }
}
