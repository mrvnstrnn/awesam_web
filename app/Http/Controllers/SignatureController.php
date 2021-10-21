<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Validator;

class SignatureController extends Controller
{
    public function index()
    {
        return view('signature_pad');
    }
      
    public function store (Request $request)
    {
        try {
            // return response()->json(['error' => true, 'message' => $request->all()]);
            
            $validate = Validator::make($request->all(), array(
                '*' => 'required'
            ));

            if ($validate->passes()) {

                for ($i=1; $i < count($request->all()); $i++) { 

                    $folderPath = public_path('/images');
                    
                    $image = explode(";base64,", $request->get('signature'. $i));
                          
                // return response()->json(['error' => true, 'message' => count($request->all()) ]);
                    $image_type = explode("image/", $image[0]);
                       
                    $image_type_png = $image_type[1];
                       
                    $image_base64 = base64_decode($image[1]);
                       
                    $file = $folderPath . uniqid() . '.'.$image_type_png;
                    file_put_contents($file, $image_base64);
                }

                // SubActivityValue::create([
                //     'sam_id' => 
                // ]);
    
                
                return response()->json(['error' => false, 'message' => 'Signature store successfully !!']);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
        // return back()->with('success', 'Signature store successfully !!');
    }
}
