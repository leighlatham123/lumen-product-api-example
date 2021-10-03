<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('translations')
        ->insert(
            [
                [
                    'language_id'                   => 1,
                    'product_id'                    => 1,
                    'product_name_translation'      => 'Exemple de produit',
                    'product_desc_translation'      => 'Description du produit',
                    'product_category_translation'  => 'Catégorie1',
                    'product_price_translation'     => 23.35,
                ],
                [
                    'language_id'                   => 1,
                    'product_id'                    => 2,
                    'product_name_translation'      => 'Deuxième description',
                    'product_desc_translation'      => 'Second description',
                    'product_category_translation'  => 'Catégorie2',
                    'product_price_translation'     => 11.68,
                ],
            ],
        );
    }
}
