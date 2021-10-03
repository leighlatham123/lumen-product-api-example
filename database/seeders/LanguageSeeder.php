<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')
        ->insert(
            [
                [
                    'locale'        => 'fr',
                    'name'          => 'French',
                    'date_format'   => 'dd/mm/yyyy',
                    'currency'       => 'EUR',
                ],
            ],
        );
    }
}
