<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')
        ->insert(
            [
                [
                    'product_name'      => 'Example product',
                    'product_desc'      => 'Description of product',
                    'product_category'  => 'Category1',
                    'product_price'     => 19.99,
                ],
                [
                    'product_name'      => 'Another product',
                    'product_desc'      => 'Second description',
                    'product_category'  => 'Category2',
                    'product_price'     => 10.00,
                ],
            ],
        );
    }
}
