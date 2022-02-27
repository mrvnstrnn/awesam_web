<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Vendor;
use App\Models\AddVendorProfile;
use App\Models\UserDetail;
use App\Models\VendorProgram;
use App\Models\User;
use App\Models\UserProgram;
use App\Models\Request as RequestTable;
use DataTables;
use Log;

use App\Mail\VendorMail;
use Illuminate\Support\Facades\Mail;

class VendorController extends Controller
{

    public function add_agent_request(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'request_type' => 'required',
                'start_date_requested' => 'required',
                'end_date_requested' => 'required',
                'reason' => 'required',
                // 'leave_status' => 'required'
            ));

            if($validate->passes()){
                $supervisor = UserDetail::select('IS_id')->where('user_id', \Auth::id())->first();
                
                // return response()->json(['error' => true, 'message' => $request->all() ]);
                RequestTable::create([
                    'agent_id' => \Auth::id(),
                    'supervisor_id' => $supervisor->IS_id,
                    'request_type' => $request->input('request_type'),
                    'start_date_requested' => $request->input('start_date_requested'),
                    'end_date_requested' => $request->input('end_date_requested'),
                    'reason' => $request->input('reason'),
                    'leave_status' => "active",
                ]);
        
                return response()->json(['error' => false, 'message' => "Successfully requested." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }
    
    public function add_vendor(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'vendor_firstname' => 'required',
                'vendor_lastname' => 'required',
                'vendor_admin_email' => ['required', 'unique:users,email', 'unique:vendor,vendor_admin_email'],
                'vendor_program_id' => 'required',
                'vendor_sec_reg_name' => 'required',
                'vendor_acronym' => 'required',
                'vendor_office_address' => 'required',
                'vendor_status' => 'required',
                'vendor_profile_id' => 'required',
            ));

            if ($validate->passes()){

                // return response()->json(['error' => true, 'message' => $request->all() ]);

                $name = $request->input('vendor_firstname')." ".$request->input('vendor_lastname');


                $arrayData = array(
                    'vendor_firstname' => $request->input('vendor_firstname'),
                    'vendor_lastname' => $request->input('vendor_lastname'),
                    'vendor_admin_email' => $request->input('vendor_admin_email'),
                    'vendor_sec_reg_name' => $request->input('vendor_sec_reg_name'),
                    'vendor_acronym' => $request->input('vendor_acronym'),
                    'vendor_office_address' => $request->input('vendor_office_address'),
                    'vendor_status' => $request->input('vendor_status'),
                    'vendor_profile_id' => $request->input('vendor_profile_id')[0],
                );

                Mail::to($request->input('vendor_admin_email'))->send(new VendorMail(
                    $name,
                    $request->input('vendor_admin_email'),
                    $request->input('vendor_sec_reg_name'),
                    $request->input('vendor_acronym')
                ));

                if(is_null($request->input('vendor_id'))) {

                    $vendor_id = \DB::table('vendor')->insertGetId(
                        $arrayData
                    );

                    $users = new User();
                    $users->firstname = $request->input('vendor_firstname');
                    $users->lastname = $request->input('vendor_lastname');
                    $users->name = $name;
                    $users->email = $request->input('vendor_admin_email');
                    $users->email_verified_at = \Carbon::now();
                    $users->password = Hash::make(12345678);
                    $users->profile_id = 1;
                    $users->save();

                    for ($i=0; $i < count($request->input('vendor_program_id')); $i++) {
                        $vendor_program = new VendorProgram();
                        $vendor_program->vendors_id = $vendor_id;
                        $vendor_program->programs = $request->input('vendor_program_id')[$i];
                        $vendor_program->save();

                        $user_program = new UserProgram();
                        $user_program->user_id = $users->id;
                        $user_program->program_id = $request->input('vendor_program_id')[$i];
                        $user_program->save();
                    }

                    for ($j=0; $j < count($request->input('vendor_profile_id')); $j++) {
                        $vendor_program = new AddVendorProfile();
                        $vendor_program->vendor_id = $vendor_id;
                        $vendor_program->vendor_profile = $request->input('vendor_profile_id')[$j];
                        $vendor_program->save();
                    }

                    return response()->json(['error' => false, 'message' => "Successfully added vendor." ]);
                } else {

                    for ($i=0; $i < count($request->input('vendor_program_id')); $i++) { 
                        VendorProgram::create([
                            'vendors_id' => $vendor_id,
                            'programs' => $request->input('vendor_program_id')[$i],
                        ]);
                    }

                    for ($i=0; $i < count($request->input('vendor_profile_id')); $i++) { 
                        AddVendorProfile::create([
                            'vendor_id' => $vendor_id,
                            'vendor_profile' => $request->input('vendor_profile_id')[$i],
                        ]);
                    }
                    
                    \DB::table('vendor')
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
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json([ 'error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function all_vendor()
    {
        try {
            $vendors = Vendor::join('vendor_programs', 'vendor_programs.vendor_program_id', 'vendors.vendor_program_id')
                                    // ->whereNot('vendors', 'HT')
                                    ->get();
            return response()->json([ 'error' => false, 'message' => $vendors ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json([ 'error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function get_vendor($vendor_id)
    {
        try {
            $vendors = Vendor::join('vendor_programs', 'vendor_programs.vendor_program_id', 'vendors.vendor_program_id')
                                    // ->where('vendors.vendor_id', $vendor_id)
                                    ->first();

            return response()->json([ 'error' => false, 'message' => $vendors ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
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
            
            $vendors = \DB::table('vendor')
                                    ->whereIn('vendor_status', $arrayProgram)
                                    ->get();

            $dt = DataTables::of($vendors)
                        ->addColumn('vendor_status', function($row){
                            $class = $row->vendor_status == 'Active' || $row->vendor_status == 'Complete Offboarding' ? 'success' : 'warning';
                            return '<div class="badge badge-'.$class.'" ml-2">'.$row->vendor_status.'</div>';
                        })
                        ->addColumn('action', function($row) use ($program_status){
                            $button = '<button class="btn btn-info view-info btn-sm infoVendorModal" data-href="'.route('info.vendor', $row->vendor_id).'" data-id="'.$row->vendor_id.'" title="View Info"><i class="fa fa-eye"></i></button>';

                            $button .= ' <a class="btn btn-info view-info btn-sm" href="'.route('site.vendor', $row->vendor_id).'" data-id="'.$row->vendor_id.'" title="View sites"><i class="pe-7s-global"></i></a>';

                            if ($program_status != "Complete"){
                                $button .= ' <button class="btn btn-danger view-info btn-sm modalTerminate" data-vendor_sec_reg_name="'.$row->vendor_sec_reg_name.'" data-statusb="'.$program_status.'" data-id="'.$row->vendor_id.'">Terminate</button>';
                            }
                            
                            return $button;
                        })
                        ->addColumn('vendor_name', function($row){
                            return $row->vendor_firstname. " " .$row->vendor_lastname;
                        });
            
            $dt->rawColumns(['vendor_status', 'action']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
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

            $site = \DB::table('site')
                                        ->where('site_vendor_id', $request->input('id'))
                                        ->get();

            if (!is_null($site)) {
                return response()->json(['error' => true, 'message' => 'Unable to terminate this vendor. Transfer all '.count($site).' sites assigned to this vendor. <br><a href="'.route('site.vendor', $request->input('id')).'" target="_blank">View sites</a>']);
            }

            \DB::table('vendor')
                        ->where('vendor_id', $request->input('id'))
                        ->update([
                            'vendor_status' => $status
                        ]);

            return response()->json(['error' => false, 'message' => 'Successfully terminated a vendor.']);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
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
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function info_vendor($vendor_id)
    {
        try {
            $vendor = Vendor::find($vendor_id);

            $vendor_profiles = AddVendorProfile::join('vendor_profile', 'vendor_profile.id', 'add_vendor_profile.vendor_profile')
                                                    ->where('add_vendor_profile.vendor_id', $vendor_id)
                                                    ->get();
                                                    
            return response()->json(['error' => false, 'message' => $vendor, 'vendor_profiles' => $vendor_profiles]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function site_vendor_table($vendor_id)
    {
        try {
            $site_vendor = \DB::table('site')->where('site_vendor_id', $vendor_id)->get();

            $dt = DataTables::of($site_vendor)
                        ->addColumn('checkbox', function($row) {
                            $checkbox = "<div class='custom-checkbox custom-control'>";
                            $checkbox .= "<input type='checkbox' name='program id='checkbox_".$row->sam_id."' value='".$row->sam_id."' class='custom-control-input checkbox-new-endorsement'>";
                            $checkbox .= "<label class='custom-control-label' for='checkbox_".$row->sam_id."'></label>";
                            $checkbox .= "</div>";
    
                            return $checkbox;
                        })
                        ->addColumn('action', function($row) {
                            $action = "<button class='btn btn-primary btn-sm transferModal' data-id='".$row->sam_id."'>Transfer</button>";
    
                            return $action;
                        });
                        
            $dt->rawColumns(['checkbox', 'action']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function get_vendor_list()
    {
        try {
            $vendor = Vendor::select('vendor.vendor_id', 'users.email', 'vendor.vendor_sec_reg_name', 'vendor.vendor_acronym')
                                ->where('vendor.vendor_status', 'Active')
                                ->join('users', 'users.email', 'vendor.vendor_admin_email')
                                ->get();
            return response()->json(['error' => false, 'message' => $vendor]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function transfer_vendor(Request $request)
    {
        try {
            \DB::table('site')
                                        ->where('sam_id', $request->input('sam_id'))
                                        ->update(['site_vendor_id' => $request->input('vendor_id')]);
            return response()->json(['error' => false, 'message' => "Successfully transfer site."]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function approvereject_agent_request (Request $request)
    {
        try {

            // if($request->input('data_action') == 'denied'){
            //     $valid = 'required';
            // }

            
            // return response()->json(['error' => true, 'message' => $request->all() ]);

            $valid = $request->input('data_action') == 'denied' ? "required" : "";

            $validate = Validator::make($request->all(), array(
                'reason' => $valid
            ));

            if ($validate->passes()){
                RequestTable::where('id', $request->input('data_id'))
                ->update([
                    'leave_status' => $request->input('data_action'),
                    'comment' => $request->input('reason'),
                ]);

                return response()->json(['error' => false, 'message' => "Successfully ".$request->input('data_action')." request."]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()->all()]);
            }

            
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        } 
    }
}