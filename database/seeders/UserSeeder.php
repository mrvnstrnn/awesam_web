<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
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
        $profiles = Profile::get();

        foreach ($profiles as $profile) {
            $name = explode(' ', trim($profile->profile));
            User::create([
                'firstname' => $name[0],
                'lastname' => count($name) < 2 ? ucfirst($profile->mode) : $name[1],
                'name' => count($name) < 2 ? ucfirst($profile->mode) : $name[0]. ' ' .$name[1],
                'email' => strtolower(str_replace(' ', '-', $profile->profile)).'@'.$profile->mode.'.ph',
                'profile_id' => $profile->id,
                'email_verified_at' => Carbon::now()->toDate(),
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
