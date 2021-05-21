<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStage extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'program_stages';


    // public function get($program_id)
    // {
    //     return ProgramStage::where("program_id", $program_id)
    //         ->orderBy('stage_sequence')
    //         ->get();
            
    // }

}
