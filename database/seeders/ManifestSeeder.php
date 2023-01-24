<?php

namespace Database\Seeders;

use App\Models\Manifest;
use Illuminate\Database\Seeder;

class ManifestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Manifest::factory()
            ->count(5)
            ->create();
    }
}
