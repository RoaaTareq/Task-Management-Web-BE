<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['category' => 'UX'],
            ['category' => 'Developer'],
            ['category' => 'QA'],
        ]);
    }
}
