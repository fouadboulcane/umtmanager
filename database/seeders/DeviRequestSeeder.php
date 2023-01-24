<?php

namespace Database\Seeders;

use App\Models\DeviRequest;
use Illuminate\Database\Seeder;

class DeviRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeviRequest::factory()
            ->count(5)
            ->create();
    }
}
