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
            ['1', '1'],
            ['1', '9'],
            ['1', '10'],

            ['2', '3'],
            ['2', '5'],
            ['2', '6'],
            ['2', '7'],
            ['2', '9'],

            ['3', '3'],
            ['3', '4'],
            ['3', '5'],
            ['3', '6'],
            ['3', '7'],
            ['3', '8'],
            ['3', '9'],

            ['4', '2'],
            ['4', '9'],

            ['5', '5'],
            ['5', '9'],
            ['5', '11'],

            ['6', '3'],
            ['6', '4'],
            ['6', '5'],
            ['6', '9'],

            ['7', '3'],
            ['7', '4'],
            ['7', '5'],
            ['7', '9'],

            ['8', '3'],
            ['8', '4'],
            ['8', '5'],
            ['8', '9'],

            ['9', '3'],
            ['9', '4'],
            ['9', '5'],
            ['9', '9'],

            ['10', '3'],
            ['10', '4'],
            ['10', '5'],
            ['10', '9'],
            
        ];

        for ($i=0; $i < count($data); $i++) { 
            ProfilePermission::create([
                'profile_id' => $data[$i][0],
                'permission_id' => $data[$i][1]
            ]);
        }
    }
}
