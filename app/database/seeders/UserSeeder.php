<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Sam',
            'email' => 's.vandekreeke@developers.nl',
            'password' => Hash::make('lf3d5D.'),
        ]);

        DB::table('users')->insert([
            'name' => 'Jesse',
            'email' => 'j.verhoeff@developers.nl',
            'password' => Hash::make('DdlfjT5'),
        ]);
    }
}
