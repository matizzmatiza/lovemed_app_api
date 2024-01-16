<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dodaj użytkownika startowego OWNER
        DB::table('users')->insert([
            'name' => 'Mateusz',
            'surname' => 'Tuczyński',
            'phone_number' => '695734954',
            'email' => 'mateusz@bytebuilders.pl',
            'password' => Hash::make('Pomidor1'),
            'rank_id' => 1,
        ]);
    }
}