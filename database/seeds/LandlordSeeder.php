<?php

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class LandlordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tenant::create([
            'name' => 'Laravel',
            'domain' => 'laravel.'.$_ENV['APP_URL_BASE'],
            'database' => 'laravel',
        ]);

        Tenant::create([
            'name' => 'Paravel',
            'domain' => 'paravel.'.$_ENV['APP_URL_BASE'],
            'database' => 'paravel',
        ]);
    }
}
