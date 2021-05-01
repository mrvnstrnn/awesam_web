<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilePermission;

class ProfilePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['8', '4'],
            ['8', '5'],
            ['8', '6'],
            ['3', '1'],
            ['3', '2'],
            ['3', '3'],
            ['1', '1'],
            ['1', '2'],
            ['1', '3'],
            ['2', '1'],
            ['2', '2'],
            ['2', '3'],

            ['7', '19'],
            ['7', '18'],
            ['7', '17'],
            ['7', '16'],
            ['7', '15'],
            ['7', '14'],
            ['7', '13'],
            ['7', '12'],
            ['7', '11'],
            ['7', '10'],
            ['7', '9'],
            ['7', '8'],
            ['7', '7'],

            ['6', '20'],
            ['5', '20'],
        ];

        for ($i=0; $i < count($data); $i++) { 
            ProfilePermission::create([
                'profile_id' => $data[$i][0],
                'permission_id' => $data[$i][1]
            ]);
        }
    }
}
