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
                Vendor::create($request->all());
                return response()->json(['error' => false, 'message' => "Successfully added vendor." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }

        } catch (\Throwable $th) {
            return response()->json([ 'error' => true, 'message' => $th->getMessage() ]);
        }
    }
}
