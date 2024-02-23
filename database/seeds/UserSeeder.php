<?php

use App\Models\User;
use Illuminate\Database\Seeder;
//use faker\factory as faker;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Mohamed',
            'email' => Faker::create()->email,
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
    }
}
