<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function add_vendor(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'vendor_fullname' => 'required',
                'vendor_admin_email' => 'required | email',
                'vendor_program_id' => 'required',
                'vendor_sec_reg_name' => 'required',
                'vendor_acronym' => 'required',
                'vendor_office_address' => 'required',
                'vendor_saq_status' => 'required',
            ));

            if ($validate->passes()){
                Vendor::updateOrCreate(
                    ['vendor_id' => $request->input('vendor_id')]
                    , $request->all()
                );

                if(is_null($request->input('vendor_id'))) {
                    return response()->json(['error' => false, 'message' => "Successfully added vendor." ]);
                } else {
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
}