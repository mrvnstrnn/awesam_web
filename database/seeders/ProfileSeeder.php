<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $globe = [
            'Program Staff',
            'Program Supervisor',
            'Program Lead'
        ];

        $vendor = [
            'STS Vendor Manager',
            'GT Admin',
            'Vendor Admin',
            'Supervisor',
            'Agent'
        ];

        for ($i=0; $i < count($globe); $i++) { 
            Profile::create([
                'mode' => 'globe',
                'profile' => $globe[$i]
            ]);
        }

        for ($i=0; $i < count($vendor); $i++) { 
            Profile::create([
                'mode' => 'vendor',
                'profile' => $vendor[$i]
            ]);
        }
    }
}
