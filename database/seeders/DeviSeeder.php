<?php

namespace Database\Seeders;

use App\Models\Devi;
use Illuminate\Database\Seeder;

class DeviSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Devi::factory()
            ->count(5)
            ->create();
    }
}
