<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     */
    public function run()
    {
        if (isset($_SERVER['argv']) && !empty($_SERVER['argv'][1]) && $_SERVER['argv'][1] != 'tenants:migrate') {
            $this->call(LandlordSeeder::class);
        }


        $this->call(UserSeeder::class);
    }
}
