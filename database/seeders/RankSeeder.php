<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rank::create(['name' => 'owner']);
        Rank::create(['name' => 'organizer']);
        Rank::create(['name' => 'juror']);
        Rank::create(['name' => 'member']);
    }
}