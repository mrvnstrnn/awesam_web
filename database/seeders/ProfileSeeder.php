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

        $vendor = [
            'Vendor Admin',
            'Agent',
            'Supervisor',
        ];

        $globe = [
            'GT Admin',
            'STS Vendor Admin',
            'STS Staff',
            'STS Head',
            'Program Staff',
            'Program Supervisor',
            'Program Head',
        ];

        for ($i=0; $i < count($vendor); $i++) { 
            Profile::create([
                'mode' => 'vendor',
                'profile' => $vendor[$i]
            ]);
        }
        
        for ($i=0; $i < count($globe); $i++) { 
            Profile::create([
                'mode' => 'globe',
                'profile' => $globe[$i]
            ]);
        }
    }
}
