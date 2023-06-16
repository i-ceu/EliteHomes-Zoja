<?php

namespace Database\Seeders;

use App\Models\Favourite;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FavouriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Favourite::factory()->count(10)
            ->create();
    }
}
