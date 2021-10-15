<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Vendor;
use App\Models\User;
use App\Models\ToweCoFile;
use App\Exports\TowerCoExport;

use Maatwebsite\Excel\Facades\Excel;
use Log;
use Validator;


class TowerCoController extends Controller
{
    public function get_towerco()
    {

        $user_detail = \Auth::user()->getUserDetail()->first();
        $vendor = Vendor::where('vendor_id', $user_detail->vendor_id)->first();

        return dd($vendor);

        $sites = \DB::connection('mysql2')
                    ->table("towerco")
                    ->where('TOWERCO', $vendor->vendor_acronym)
                    ->get();

        $dt = DataTables::of($sites);
        return $dt->make(true);
    }

    public function rename_file($filename_data, $sub_activity_name, $sam_id, $site_category = null)
    {
        $ext = pathinfo($filename_data, PATHINFO_EXTENSION);

        $file_name = strtolower($sam_id."-".str_replace(" ", "-", $sub_activity_name)).".".$ext;

        if (file_exists( public_path()."/files/".$file_name )) {

            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);

            $exploaded_name = explode("-", $withoutExt);

            if ( is_numeric( end( $exploaded_name) ) ) {
                $counter =  end( $exploaded_name) + "01";
            } else {
                $counter =  strtolower(str_replace(" ", "-", $sub_activity_name))."-01";
            }

            $imploded_name = implode("-", array_slice($exploaded_name, 0, -1));

            $cat = $site_category == 'none' ? "-" : "-".$site_category."-";

            $new_file = $imploded_name .$cat. $counter . "." .$ext;

            while (file_exists( public_path()."/files/". $new_file)) {
                $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $new_file);

                $exploaded_name = explode("-", $withoutExt);

                if ( is_numeric( end( $exploaded_name) ) ) {
                    $counter =  end( $exploaded_name) + "01";
                } else {
                    $counter =  "01";
                }

                $imploded_name = implode("-", array_slice($exploaded_name, 0, -1));

                $new_file = $imploded_name . "-" . $counter . "." .$ext;
            }

            return $new_file = $new_file;

        } else {
            return $new_file = $file_name;
        }
    }

    public function get_towerco_all($actor)
    {

        switch($actor){

            // case 'APMO-APM': 
            //     $sites = \DB::connection('mysql2')
            //     ->table("towerco")
            //     ->get();
            //     break;

            // case 'AEPM': 
            //     $sites = \DB::connection('mysql2')
            //     ->table("towerco")
            //     ->get();
            //     break;

            // case 'STS': 
            //     $sites = \DB::connection('mysql2')
            //     ->table("towerco")
            //     ->get();
            //     break;

            // case 'AGILE': 
            //     $sites = \DB::connection('mysql2')
            //     ->table("towerco")
            //     ->select("Search Ring", "TOWERCO", "PROJECT TAG", "MILESTONE STATUS", "PROVINCE", "TOWN", "REGION", "TSSR STATUS", "OFF-GRID/GOOD GRID")
            //     ->get();
            //     break;

            // case 'RAM': 
            //     $sites = \DB::connection('mysql2')
            //     ->table("towerco")
            //     ->get();
            //     break;

            case 'TOWERCO':
                $user_detail = \Auth::user()->getUserDetail()->first();
                $vendor = Vendor::where('vendor_id', $user_detail->vendor_id)->first();
                
                $sites = \DB::connection('mysql2')
                    ->table("towerco");
                
                    if(!is_null($vendor)){
                        $sites = $sites->where('TOWERCO', $vendor->vendor_acronym);
                    }

                    $sites->get();
                break;
                
            default: 
                $sites = \DB::connection('mysql2')
                ->table("towerco")
                ->select("Search Ring", "TOWERCO", "PROJECT TAG", "MILESTONE STATUS", "PROVINCE", "TOWN", "REGION", "TSSR STATUS", "OFF-GRID/GOOD GRID", "Serial Number")
                ->get();
    }

        $dt = DataTables::of($sites);
        return $dt->make(true);
    }


    public function get_towerco_serial($serial, $who)
    {
        $site = \DB::connection('mysql2')
                    ->table("towerco")
                    ->where('Serial Number', $serial)
                    ->get();

        if($who == 'towerco'){

            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'TOWERCO')
                    ->get();

            $detail_alloweds = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.view_profile', 'TOWERCO')
                    ->get();

        }
        elseif($who == 'ram'){
            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'RAM')
                    ->get();
                    
            $detail_alloweds = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.view_profile', 'RAM')
                    ->get();
        }
        elseif($who == 'sts'){

            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'STS')
                    ->get();

            $detail_alloweds = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.view_profile', 'STS')
                    ->get();
        }
        elseif($who == 'agile'){

            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'AGILE')
                    ->get();

                    
            $detail_alloweds = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.view_profile', 'AGILE')
                    ->get();
        }
        elseif($who == 'aepm'){

            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'AEPM')
                    ->get();

                    
            $detail_alloweds = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.view_profile', 'AEPM')
                    ->get();
        }
        elseif($who == 'apmo-apm'){

            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'APMO-APM')
                    ->get(); 

                    
            $detail_alloweds = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.view_profile', 'APMO-APM')
                    ->get();
        }
        
        $details = '';
        $actor = '<form id="form-towerco-actor">
            <input type="hidden" name="update user" value="' .   \Auth::user()->id . '">
            <input type="hidden" name="update group" value="' . $who . '">
        ';

        foreach ($site[0] as $col => $value){

            if($col == 'Serial Number'){
                $actor .= '<input type="hidden" id="multi_serial" name="Serial Number" value="' . $value . '">';
            }

            foreach ($allowed_fields as $allowed_field){
                
                if($col == $allowed_field->towerco_fields){

                    $actor .= '
                        <div class="row border-bottom mb-1 pb-1">
                            <div class="col-md-4">
                                ' . $col . '
                            </div>
                            <div class="col-md-8">';

                            if($allowed_field->field_type =='date'){
                                $actor .= '
                                <input type="text" name="'. $col . '" value="' . $value . '"  data-old="'. $value .'" class="form-control flatpicker">
                                ';
                            }
                            elseif($allowed_field->field_type =='text'){
                                $actor .= '
                                <input type="text" name="'. $col . '" value="' . $value . '" data-old="'. $value .'" class="form-control">
                                ';
                            }
                            elseif($allowed_field->field_type =='number'){
                                $actor .= '
                                <input type="number" name="'. $col . '" value="' . $value . '" data-old="'. $value .'" class="form-control">
                                ';
                            }
                            elseif($allowed_field->field_type =='selection'){
                                $actor .= '
                                    <select class="form-control" name="' . $col . '" data-old="'. $value .'" >
                                        <option value=""></option>
                                ';

                                $output = str_replace(array('[',']'), '', $allowed_field->selection );

                                $array_fields = explode(",", $output);

                                // foreach($allowed_field->selection as $option){

                                for ($i=0; $i < count($array_fields); $i++) { 
                                    if ($array_fields[$i] != "''") {
                                        if($array_fields[$i] == $value){
                                            $actor .= '
                                                <option value="' . str_replace("'", '', $array_fields[$i]) . '" selected>' . str_replace("'", '', $array_fields[$i]) . '</option>
                                            ';
                                        }
                                        else {
                                            $actor .= '
                                                <option value="' . str_replace("'", '', $array_fields[$i]) . '">' . str_replace("'", '', $array_fields[$i]) . '</option>
                                            ';
                                        }
                                    }
                                }

                                $actor .= '
                                    </select>
                                ';                        
                            }
                    $actor .= '        
                            </div>
                        </div>
                    ';

                    // break;
                }
            }

            foreach ($detail_alloweds as $detail_allowed){
                if($col == $detail_allowed->towerco_fields){
                    $details .= '
                        <div class="row border-bottom mb-1 pb-1">
                            <div class="col-md-4">
                                ' . $col . '
                            </div>
                            <div class="col-md-8">
                                <input type="text" value="' . $value . '" class="form-control" readonly>
                            </div>
                        </div>';
                }
            }
            
        }

        $actor .="</form>";


        return response()->json([ 'error' => false, 'details' => $details, 'actor' => $actor ]);


    }

    public function get_towerco_multi($who)
    {
        if($who == 'towerco'){

            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'TOWERCO')
                    ->get();

        }
        elseif($who == 'ram'){
            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'RAM')
                    ->get();
        }
        elseif($who == 'sts'){

            
            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'STS')
                    ->get();
        }
        elseif($who == 'agile'){

            
            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'AGILE')
                    ->get(); 
        }
        elseif($who == 'aepm'){

            
            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'AEPM')
                    ->get();
        }
        elseif($who == 'apmo-apm'){

            
            $allowed_fields = \DB::connection('mysql2')
                    ->table("tower_fields_map")
                    ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
                    ->where('tower_fields_map_profile.edit_profile', 'AEPM-APM')
                    ->get(); 
        }

        $actor = '<form id="form-towerco-actor-multi">
            <input type="hidden" name="update user" value="' .   \Auth::user()->id . '">
            <input type="hidden" name="update group" value="' . $who . '">
        ';

            $value='';

            // foreach ($allowed_fields as $allowed_field){

            //         $actor .= '
            //             <div class="row border-bottom mb-1 pb-1">
            //                 <div class="col-md-4">
            //                     ' . $allowed_field['field'] . '
            //                 </div>
            //                 <div class="col-md-8">';

            //         if($allowed_field->field_type == 'date'){
            //             $actor .= '
            //             <input type="text" name="'. $allowed_field['field'] . '" value="' . $value . '"  data-old="'. $value .'" class="form-control flatpicker">
            //             ';
            //         }
            //         elseif($allowed_field->field_type == 'text'){
            //             $actor .= '
            //             <input type="text" name="'. $allowed_field['field'] . '" value="' . $value . '" data-old="'. $value .'" class="form-control">
            //             ';
            //         }
            //         elseif($allowed_field->field_type == 'number'){
            //             $actor .= '
            //             <input type="number" name="'. $allowed_field['field'] . '" value="' . $value . '" data-old="'. $value .'" class="form-control">
            //             ';
            //         }
            //         elseif($allowed_field->field_type == 'selection'){
            //             $actor .= '
            //                 <select class="form-control" name="' . $allowed_field['field'] . '" data-old="'. $value .'" >
            //                     <option value=""></option>
            //             ';

            //             $output = str_replace(array('[',']'), '', $allowed_field->selection );

            //             $array_fields = explode(",", $output);

            //             // foreach($allowed_field->selection as $option){

            //             for ($i=0; $i < count($array_fields); $i++) { 
            //                 if ($array_fields[$i] != "''") {
            //                     if($array_fields[$i] == $value){
            //                         $actor .= '
            //                             <option value="' . str_replace("'", '', $array_fields[$i]) . '" selected>' . str_replace("'", '', $array_fields[$i]) . '</option>
            //                         ';
            //                     }
            //                     else {
            //                         $actor .= '
            //                             <option value="' . str_replace("'", '', $array_fields[$i]) . '">' . str_replace("'", '', $array_fields[$i]) . '</option>
            //                         ';
            //                     }
            //                 }
            //             }

            //             $actor .= '
            //                 </select>
            //             ';                        
            //         }
            //         $actor .= '        
            //                 </div>
            //             </div>
            //         ';

            // }

            foreach ($allowed_fields as $allowed_field){

                $actor .= '
                    <div class="row border-bottom mb-1 pb-1">
                        <div class="col-md-4">
                            ' . $allowed_field->towerco_fields . '
                        </div>
                        <div class="col-md-8">';

                if($allowed_field->field_type == 'date'){
                    $actor .= '
                    <input type="text" name="'. $allowed_field->towerco_fields . '" value="' . $value . '"  data-old="'. $value .'" class="form-control flatpicker">
                    ';
                }
                elseif($allowed_field->field_type == 'text'){
                    $actor .= '
                    <input type="text" name="'. $allowed_field->towerco_fields . '" value="' . $value . '" data-old="'. $value .'" class="form-control">
                    ';
                }
                elseif($allowed_field->field_type == 'number'){
                    $actor .= '
                    <input type="number" name="'. $allowed_field->towerco_fields . '" value="' . $value . '" data-old="'. $value .'" class="form-control">
                    ';
                }
                elseif($allowed_field->field_type == 'selection'){
                    $actor .= '
                        <select class="form-control" name="' . $allowed_field->towerco_fields . '" data-old="'. $value .'" >
                            <option value=""></option>
                    ';

                    $output = str_replace(array('[',']'), '', $allowed_field->selection );

                    $array_fields = explode(",", $output);

                    // foreach($allowed_field->selection as $option){

                    for ($i=0; $i < count($array_fields); $i++) { 
                        if ($array_fields[$i] != "''") {
                            if($array_fields[$i] == $value){
                                $actor .= '
                                    <option value="' . str_replace("'", '', $array_fields[$i]) . '" selected>' . str_replace("'", '', $array_fields[$i]) . '</option>
                                ';
                            }
                            else {
                                $actor .= '
                                    <option value="' . str_replace("'", '', $array_fields[$i]) . '">' . str_replace("'", '', $array_fields[$i]) . '</option>
                                ';
                            }
                        }
                    }

                    $actor .= '
                        </select>
                    ';                        
                }
                $actor .= '        
                        </div>
                    </div>
                ';

        }

        $actor .="</form>";



        return response()->json([ 'error' => false, 'actor' => $actor ]);


    }

    public function get_towerco_logs($serial)
    {

        try {
            $logs = \DB::connection('mysql2')
            ->table("towerco_logs")
            ->join("users","users.id", "towerco_logs.user_id")
            ->where('Serial Number', $serial)
            ->orderBy('towerco_logs.add_timestamp', 'DESC')
            ->get();
    
            $dt = DataTables::of($logs);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
        
    }

    public function save_towerco_serial(Request $request)
    {
        try {

            $data = collect($request->all())->mapWithKeys(function($item, $key) {
                    return [str_replace("_", " ", $key) => $item];
            })->toArray();

            // return dd($data);
            unset($data['Serial Number']);


            // return response()->json(['error' => true, 'message' => $request['Serial_Number']]);
            \DB::enableQueryLog(); // Enable query log

            \DB::table('towerco')
                ->where('Serial Number', $request['Serial_Number'])
                ->update(array_filter($data));

            // return dd(\DB::getQueryLog()); // Show results of log

            return response()->json([ 'error' => false, 'message' => "Successfully updated site", 'db' => \DB::getQueryLog() ]);    



        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);

            return response()->json(['error' => true, 'message' => $th->getMessage()]);

        }

    }

    public function save_towerco_multi(Request $request)
    {
        try {

            $data = collect($request->all())->mapWithKeys(function($item, $key) {
                    return [str_replace("_", " ", $key) => $item];
            })->toArray();
            unset($data['Serial Number']);


            \DB::enableQueryLog(); // Enable query log

            \DB::table('towerco')
                ->whereIn('Serial Number', $request['Serial_Number'])
                ->update(array_filter($data));

            // \DB::connection('mysql2')
            //     ->table('towerco_logs')
            //     ->insert([
            //     'Serial Number' => 'kayla@example.com',
            //     'field' => '',
            //     'old_value' => '',
            //     'new_value' => ''
            // ]);

            return response()->json([ 'error' => false, 'message' => "Successfully updated site", 'db' => \DB::getQueryLog() ]);    


        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);

            return response()->json(['error' => true, 'message' => $th->getMessage()]);

        }

    }

    public function filter_towerco($towerco = null, $region, $tssr_status, $milestone_status, $actor)
    {
        // $base_sql = "select * from `towerco`";

        // if($towerco != '-' || $region != '-'|| $tssr_status != '-' || $milestone_status != '-'){
        //     $base_sql .= " WHERE ";
        // }

        // $conditions = [];

        // if($towerco != '-'){
        //     array_push($conditions, " `TOWERCO` = '" . $towerco . "'");
        // }

        // if($region != '-'){
        //     array_push($conditions, " `REGION` = '" . $region . "'");
        // }

        // if($tssr_status != '-'){
        //     array_push($conditions, " `TSSR STATUS` = '" . $tssr_status . "'");
        // }
        // if($milestone_status != '-'){
        //     array_push($conditions, " `MILESTONE STATUS` = '" . $milestone_status . "'");
        // }


        $sites = \DB::connection('mysql2')
                        ->table('towerco');

        if($towerco != '-' && $actor != 'TowerCo'){
            $sites = $sites->where('TOWERCO', $towerco != '-' ? $towerco : "");
        
        } else {
            $user_detail = \Auth::user()->getUserDetail()->first();
            $vendor = Vendor::where('vendor_id', $user_detail->vendor_id)->first();

            $sites = $sites->where('TOWERCO', $vendor->vendor_acronym);
        }

        if($region != '-'){
            $sites = $sites->where('REGION', $region != '-' ? $region : "");
        }

        if($tssr_status != '-'){
            $sites = $sites->where('TSSR STATUS', $tssr_status != '-' ? $tssr_status : "");
        }
        if($milestone_status != '-'){
            $sites = $sites->where('MILESTONE STATUS', $milestone_status != '-' ? $milestone_status : "");
        }

        $rows = $sites->get();

        $dt = DataTables::of($rows);
        return $dt->make(true);

    }


    public function TowerCoExport()
    {
        return Excel::download(new TowerCoExport, 'towerco.xlsx');
    }

    public function get_my_towerco_file ($serial_number, $type)
    {
        try {
            $towerco_files = \DB::connection('mysql2')
                        ->table("towerco_files")
                        ->join('users', 'users.id', 'towerco_files.user_id')
                        ->where('towerco_files.serial_number', $serial_number)
                        ->where('towerco_files.type', $type)
                        ->get();
    
            $dt = DataTables::of($towerco_files)
                    ->addColumn('uploaded_by', function($row){
                        return $row->name;                            
                    });
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function upload_my_file_towerco(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'file_name' => 'required',
            ));

            $new_file = $this->rename_file($request->input("file_name"), $request->input("activity_name"), $request->input("serial_number"));

            \Storage::move( $request->input("file_name"), $new_file );

            if($validate->passes()){

                ToweCoFile::create([
                    'serial_number' => $request->input("serial_number"),
                    'file_name' => $new_file,
                    'type' => $request->input("activity_name"),
                    'user_id' => \Auth::id(),
                ]);            
                
                return response()->json(['error' => false, 'message' => "Successfully uploaded a file."]);
            } else {
                return response()->json(['error' => true, 'message' => "Please upload a file."]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

}
