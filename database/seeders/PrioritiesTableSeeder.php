<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritiesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('priorities')->insert([
            ['priority' => 'high'],
            ['priority' => 'medium'],
            ['priority' => 'low'],
        ]);
    }
}
