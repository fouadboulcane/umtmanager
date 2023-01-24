<?php

namespace Database\Seeders;

use App\Models\Anouncement;
use Illuminate\Database\Seeder;

class AnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Anouncement::factory()
            ->count(5)
            ->create();
    }
}
