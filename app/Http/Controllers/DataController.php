<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;


class DataController extends Controller
{

    public function Datatable_Columns(Request $request)
    {




    }



    public function Datatable_Data($program_id, $profile_id, $activity_type)
    {

        // Document Validation
       if($activity_type == 'doc validation'){

            $sites = \DB::connection('mysql2')
                ->table("views_sites_with_document_validation")
                ->leftJoin('view_site', 'views_sites_with_document_validation.sam_id', 'view_site.sam_id')
                ->where('program_id', $program_id)
                ->where('active_profile_id', \Auth::user()->profile_id)
                ->get();

        } else {
            
        }

        $dt = DataTables::of($sites);
        return $dt->make(true);

    }

    public function Program_Fields(Request $request)
    {



    }


    





}
