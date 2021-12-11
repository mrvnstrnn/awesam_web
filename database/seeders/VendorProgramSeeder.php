<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VendorProgram;

class VendorProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = [
            'New Sites',
            'FFTH',
            'Coloc',
            'IBS',
            'MWAN',
            'TowerCo',
        ];

        for ($i=0; $i < count($programs); $i++) { 
            VendorProgram::create([
                'vendor_program' => $programs[$i]
            ]);
        }

    }
}
