<?php

namespace Database\Seeders;

use App\Models\UserMeta;
use Illuminate\Database\Seeder;

class UserMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserMeta::factory()
            ->count(5)
            ->create();
    }
}
