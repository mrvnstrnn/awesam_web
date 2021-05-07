<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class GlobeController extends Controller
{
    public function getDataNewEndorsement()
    {
        try {

            $stored_procs = \DB::connection('mysql2')->select('call test_stored_proc');
    
            $dt = DataTables::of($stored_procs)
                        ->addColumn('checkbox', function($row){
                            $checkbox = "<div class='custom-checkbox custom-control'>";
                            $checkbox .= "<input type='checkbox' name='checkbox' id='checkbox_".$row->sam_id."' class='custom-control-input checkbox-new-endorsement'>";
                            $checkbox .= "<label class='custom-control-label' for='checkbox_".$row->sam_id."'></label>";
                            $checkbox .= "</div>";
    
                            return $checkbox;
                        })
                        // ->addColumn('site_name', function($row){
                        //     $technology = "<div class='text-center'><div class='badge badge-success'>" .$row->TECHNOLOGY. "</div></div>" ;
                        //     return $technology;
                        // })
                        ->addColumn('technology', function($row){
                            $technology = "<div class='text-center'><div class='badge badge-success'>" .$row->TECHNOLOGY. "</div></div>" ;
                            return $technology;
                        });
            
            $dt->rawColumns(['checkbox', 'technology']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
