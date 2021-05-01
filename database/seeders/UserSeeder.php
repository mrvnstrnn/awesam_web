<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            'firstname' => 'Globe',
            'lastname' => 'Sam',
            'name' => 'Globe Sam',
            'email' => 'sam@globe.ph',
            'profile_id' => 7,
            'email_verified_at' => Carbon::now()->toDate(),
            'password' => Hash::make('12345678'),
        ]);
    }
}
