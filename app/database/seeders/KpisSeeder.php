<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KpisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('kpis')->insert([
            'type_graph' => 'graph',
            'name' => 'application_all_day',
            'expected_value' => '6',

        ]);

        DB::table('kpis')->insert([
            'type_graph' => 'graph',
            'name' => 'application_all_month',
            'expected_value' => '120',

        ]);
    }
}
