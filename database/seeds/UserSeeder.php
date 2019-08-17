<?php

use App\User;
use Illuminate\Database\Seeder;

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
            'name' => 'Collin O\'Connell',
            'email' => 'ococncol@gmail.com',
            'password' => Hash::make('password'),
            'school_id' => 1
        ]);
    }
}
