<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Vendor;
use DataTables;

class VendorController extends Controller
{
    public function add_vendor(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'vendor_firstname' => 'required',
                'vendor_lastname' => 'required',
                'vendor_admin_email' => ['required', 'unique:mysql2.users,email', 'unique:mysql2.vendor,vendor_admin_email'],
                'vendor_program_id' => 'required',
                'vendor_sec_reg_name' => 'required',
                'vendor_acronym' => 'required',
                'vendor_office_address' => 'required',
                'vendor_status' => 'required',
            ));

            if ($validate->passes()){
                $arrayData = array(
                    'vendor_firstname' => $request->input('vendor_firstname'),
                    'vendor_lastname' => $request->input('vendor_lastname'),
                    'vendor_admin_email' => $request->input('vendor_admin_email'),
                    'vendor_sec_reg_name' => $request->input('vendor_sec_reg_name'),
                    'vendor_acronym' => $request->input('vendor_acronym'),
                    'vendor_office_address' => $request->input('vendor_office_address'),
                    'vendor_status' => $request->input('vendor_status'),
                );
                
                if(is_null($request->input('vendor_id'))) {
                    $vendor_id = \DB::connection('mysql2')->table('vendor')->insertGetId(
                        $arrayData
                    );

                    for ($i=0; $i < count($request->input('vendor_program_id')); $i++) { 
                        $arrayProgram = array(
                            'vendors_id' => $vendor_id,
                            'programs' => $request->input('vendor_program_id')[$i],
                        );

                        \DB::connection('mysql2')->table('vendor_programs')->insert(
                            $arrayProgram
                        );
                    }

                    return response()->json(['error' => false, 'message' => "Successfully added vendor." ]);
                } else {
                    \DB::connection('mysql2')->table('vendor')
                        ->where('vendor_id', $request->input('vendor_id'))
                        ->update(
                            $arrayData
                        );
                return response()->json(['error' => false, 'message' => "Successfully updated vendor." ]);
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }

        } catch (\Throwable $th) {
            return response()->json([ 'error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function all_vendor()
    {
        try {
            $vendors = Vendor::join('vendor_programs', 'vendor_programs.vendor_program_id', 'vendors.vendor_program_id')
                                    ->get();
            return response()->json([ 'error' => false, 'message' => $vendors ]);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function get_vendor($vendor_id)
    {
        try {
            $vendors = Vendor::join('vendor_programs', 'vendor_programs.vendor_program_id', 'vendors.vendor_program_id')
                                    ->where('vendors.vendor_id', $vendor_id)
                                    ->first();

            return response()->json([ 'error' => false, 'message' => $vendors ]);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function vendor_list($program_status)
    {
        try {
            if ($program_status == 'listVendor') {
                $arrayProgram = ['Active', 'Ongoing Accreditation'];
            } else if($program_status == 'OngoingOff') {
                $arrayProgram = ['Ongoing Offboarding'];
            } else if($program_status == 'Complete') {
                $arrayProgram = ['Complete Offboarding'];
            }
            
            $vendors = \DB::connection('mysql2')->table('vendor')
                                    // ->join('vendor_programs', 'vendor_programs.vendor_program_id', 'vendor.vendor_program_id')
                                    ->whereIn('vendor_status', $arrayProgram)
                                    ->get();

            $dt = DataTables::of($vendors)
                        ->addColumn('vendor_status', function($row){
                            $class = $row->vendor_status == 'Active' || $row->vendor_status == 'Complete Offboarding' ? 'success' : 'warning';
                            return '<div class="badge badge-'.$class.'" ml-2">'.$row->vendor_status.'</div>';
                        })
                        ->addColumn('action', function($row) use ($program_status){
                            $button = '<button class="btn btn-info view-info btn-sm infoVendorModal" data-href="'.route('info.vendor', $row->vendor_id).'" data-id="'.$row->vendor_id.'" title="View Info"><i class="fa fa-eye"></i></button>';

                            if ($program_status != "Complete"){
                                $button .= ' <button class="btn btn-danger view-info btn-sm modalTerminate" data-vendor_sec_reg_name="'.$row->vendor_sec_reg_name.'" data-statusb="'.$program_status.'" data-id="'.$row->vendor_id.'">Terminate</button>';
                            }

                            if ($program_status == "OngoingOff") {
                                $button .= ' <a href="'.route('site.vendor', $row->vendor_id).'" class="btn btn-primary text-white btn-sm">View Sites</a>';
                            }

                             return $button;
                        })
                        ->addColumn('vendor_name', function($row){
                            return $row->vendor_firstname. " " .$row->vendor_lastname;
                        });
            
            $dt->rawColumns(['vendor_status', 'action']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function terminate_vendor(Request $request)
    {
        try {
            $status = '';

            // return response()->json(['error' => true, 'message' => $request->input('data_statusb')]);
            if($request->input('data_statusb') == 'listVendor'){
                $status = 'Ongoing Offboarding';
            } else if ($request->input('data_statusb') == 'OngoingOff'){
                $status = 'Complete Offboarding';
            }

            \DB::connection('mysql2')->table('vendor')
                        ->where('vendor_id', $request->input('id'))
                        ->update([
                            'vendor_status' => $status
                        ]);

            return response()->json(['error' => false, 'message' => 'Successfully terminated a vendor.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function getMyRequest($request_status)
    {
        try {
            $myrequests = \Auth::user()->getMyRequest($request_status);
            $dt = DataTables::of($myrequests)
                        ->addColumn('request_type', function($row){
                            return '<span class="badge badge-success text-uppercase">'.$row->request_type.'<span>';
                        })
                        ->addColumn('requested_date', function($row){
                            return date('M d, Y', strtotime($row->start_date_requested)). ' - ' .date('M d, Y', strtotime($row->end_date_requested));
                        });

            $dt->rawColumns(['request_type']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function info_vendor($vendor_id)
    {
        try {
            $vendor = Vendor::find($vendor_id);
            return response()->json(['error' => false, 'message' => $vendor]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }
    
    public function site_vendor($vendor_id)
    {
        try {
            $site_vendor = \DB::connection('mysql2')->table('site')->where('site_vendor_id', $vendor_id)->get();
            $dt = DataTables::of($site_vendor);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}